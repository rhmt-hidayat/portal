module.exports = {
    env: {
        browser: true,
        es2021: true,
        jest: true,
    },
    extends: ['eslint:recommended', 'plugin:react/recommended', 'plugin:react-hooks/recommended'],
    parserOptions: {
        ecmaFeatures: {
            jsx: true,
        },
        sourceType: 'module',
    },
    plugins: ['react'],
    rules: {
        indent: ['error', 4, {
            SwitchCase: 1,
        }],
        quotes: ['error', 'single'],
        'comma-dangle': ['error', 'always-multiline'],
        'multiline-ternary': ['error', 'always'],
        'array-element-newline': ['error', 'consistent'],
        'no-constant-condition': ['error', {
            checkLoops: false,
        }],
        'space-before-function-paren': [
            'error',
            {
                anonymous: 'always',
                named: 'never',
                asyncArrow: 'always',
            },
        ],
        'react/react-in-jsx-scope': 'off',
        'function-paren-newline': [
            'error',
            {
                minItems: 3,
            },
        ],
        'quote-props': ['error', 'as-needed'],
        'object-curly-spacing': ['error', 'always'],
        'no-multiple-empty-lines': [
            'error',
            {
                max: 1,
            },
        ],
        'react/prop-types': 0, // TODO: Do we want this required?
        'lines-around-comment': [
            'error',
            {
                beforeBlockComment: true,
                allowBlockStart: true,
            },
        ],
        'object-curly-newline': [
            'error',
            {
                ObjectExpression: {
                    minProperties: 1,
                },
                ObjectPattern: {
                    multiline: true,
                },
                ImportDeclaration: {
                    multiline: true,
                    minProperties: 3,
                },
                ExportDeclaration: {
                    multiline: true,
                    minProperties: 3,
                },
            },
        ],
    },
    settings: {
        react: {
            version: 'detect',
        },
    },
}
