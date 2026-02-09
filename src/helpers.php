<?php

if (! function_exists('convert_sql_to_html_input_type')) {
    /**
     * Takes an SQL column type and converts it to an appropriate HTML input type.
     * @param string $sqlType
     * @return string
     */
    function convert_sql_to_html_input_type(string $sqlType): string
    {
        // Standardize type name by removing length/constraints and converting to lowercase
        $type = strtolower(explode('(', $sqlType)[0]);

        switch ($type) {
            // Text types
            case 'varchar':
            case 'char':
            case 'text':
            case 'tinytext':
            case 'mediumtext':
            case 'longtext':
                return 'text';

                // Integer types
            case 'int':
            case 'integer':
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'bigint':
                return 'number';

                // Float/Decimal types
            case 'float':
            case 'double':
            case 'decimal':
            case 'numeric':
                return 'number';

                // Date/Time types
            case 'date':
                return 'date';
            case 'datetime':
            case 'timestamp':
                return 'datetime-local';
            case 'time':
                return 'time';
            case 'year':
                return 'number'; // A 4-digit number input is suitable for a year

                // Boolean/Enum types
            case 'boolean':
            case 'bool':
                return 'checkbox'; // Consider a checkbox or select for better UX
            case 'enum':
                return 'select'; // Enums often work best as a <select> dropdown

                // Other types
            case 'email': // If you use a custom "email" SQL type
                return 'email';
            case 'url': // If you use a custom "url" SQL type
                return 'url';

                // Default to text if no specific mapping is found
            default:
                return 'text';
        }
    }
}
