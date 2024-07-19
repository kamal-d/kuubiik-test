SET @sql = NULL;
SELECT 
    GROUP_CONCAT(DISTINCT
        CONCAT(
            'MAX(CASE WHEN p.name = ''',
            name,
            ''' THEN ',
            CASE
                WHEN type = 'string' THEN 'up.value_string'
                WHEN type = 'int' THEN 'up.value_int'
                WHEN type = 'datetime' THEN 'up.value_datetime'
                ELSE 'NULL'
            END,
            ' END) AS ',
            name
        )
    ) INTO @sql
FROM properties;

-- Step 2: Generate the dynamic SQL
SET @sql = CONCAT('SELECT u.id AS user_id, u.email, ', @sql, '
    FROM users u
    JOIN users_properties up ON u.id = up.user_id
    JOIN properties p ON up.property_id = p.id
    GROUP BY u.id, u.email');

-- Step 3: Execute the dynamic SQL
PREPARE stmt FROM @sql;
EXECUTE stmt;
