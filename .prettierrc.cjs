module.exports = {
    semi: true,
    jsxSingleQuote: true,
    singleQuote: true,
    arrowParens: 'avoid',
    trailingComma: 'es5',
    endOfLine: 'auto',
    tabWidth: 4,
    importOrder: ['^react$', '<THIRD_PARTY_MODULES>', '^@/', '^[./]'],
    importOrderSeparation: true,
    importOrderSortSpecifiers: true,
    plugins: ['@trivago/prettier-plugin-sort-imports'],
};
