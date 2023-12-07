<?php

namespace IslamBzh\stringReplace;

trait StringReplaceTrait
{
    protected static function stringReplace(string $text, array $vars): string
    {
        $search = [];
        $replace = [];

        if (str_contains($text, '[')
            && preg_match_all('/\:(\S+)\[(.*)\]/U', $text, $matches)
            && !empty($matches)
        )
            self::stringReplace_parseCount($matches, $vars, $search, $replace);

        foreach ($vars as $key => $value) {
            $search[] = ':' . $key;
            $replace[] = $value;
        }

        return str_replace($search, $replace, $text);
    }


    private static function stringReplace_parseCount(array $matches, array $vars, array &$search, array &$replace): void
    {
        $rules = [];
        foreach ($matches[0] as $i => $match) {
            if (isset($search[$match]))
                continue;

            $search[] = $match;

            if(!isset($vars[$matches[1][$i]])){
                $replace[] = ":{$matches[1][$i]}[...]";
                continue;
            }

            $variables = explode('|', $matches[2][$i]);
            $value = (int)$vars[$matches[1][$i]];

            if (!str_contains($matches[2][$i], '{')) {
                $replace[] = match ($value) {
                    0, '0' => $variables[0],
                    1, '1' => isset($variables[2])
                        ? $variables[1]
                        : $variables[0],

                    default => $variables[2] ?? $variables[1] ?? $variables[0]
                };

                continue;
            }

            if (!isset($rules[$match]))
                $rules[$match] = [];

            $replace[] = self::stringReplace_getVariableParseCount($rules[$match], $variables, $value);
        }
    }

    private static function stringReplace_getVariableParseCount(&$rules, $variables, $value)
    {
        if (empty($rules))
            foreach ($variables as $v_i => $variable) {
                if (!str_starts_with($variable, '{')) {
                    $rules['default'] = $rules['negative'] = $v_i;
                    continue;
                }

                $rule_end_pos = strpos($variable, '}');
                $v_rules = explode(',', substr($variable, 1, $rule_end_pos - 1));
                $variables[$v_i] = substr($variable, $rule_end_pos + 1);

                foreach ($v_rules as $v_rule)
                    self::stringReplace_ParseVariableRules($rules, $v_i, $v_rule);
            }

        if(!isset($rules['default'])){
            $rules['default'] = -1;
            $variables[-1] = '';
        }

        $correct = $rules['default'];

        if (isset($rules[$value]))
            return $variables[$rules[$value]];

        foreach ($rules as $rule => $v_i) {
            if (is_numeric($rule)
                && $rule == $value
            )
                $correct = $v_i;

            elseif (str_starts_with($rule, '_')
                && is_numeric(substr($rule, 1))
                && str_ends_with($value, substr($rule, 1))
            )
                $correct = $v_i;
        }

        if($value < 0
            && $correct == $rules['default']
            && isset($rules['negative'])
        )
            $correct = $rules['negative'];

        return $variables[$correct];
    }

    private static function stringReplace_ParseVariableRules(&$rules, $v_i, $v_rule): void
    {
        if ($v_rule === '*')
            $rules['default'] = $v_i;

        elseif($v_rule === '-')
            $rules['negative'] = $v_i;

        elseif (str_contains($v_rule, '-')) {
            $v_rule_vars = explode('-', $v_rule);
            if ($v_rule_vars[0] == '*')
                $rules['default'] = $v_i;

            elseif ($v_rule_vars[1] == '*')
                $rules['default'] = $v_i;

            elseif (is_numeric($v_rule_vars[0]) && is_numeric($v_rule_vars[1]))
                for ($v_rule_i = $v_rule_vars[0]; $v_rule_i <= $v_rule_vars[1]; $v_rule_i++)
                    $rules[$v_rule_i] = &$v_i;

            elseif (str_starts_with($v_rule_vars[0], '_') && str_starts_with($v_rule_vars[1], '_')) {
                $start = substr($v_rule_vars[0], 1);
                $end = substr($v_rule_vars[1], 1);
                if ($start === '*')
                    $start = 0;

                if ($end === '*')
                    $end = 9;

                if (is_numeric($start) && is_numeric($end))
                    for ($v_rule_i = $start; $v_rule_i <= $end; $v_rule_i++)
                        $rules['_' . $v_rule_i] = &$v_i;
            }
        } else
            $rules[$v_rule] = &$v_i;
    }
}