const {join,resolve} = require('path')

const scssPath = join(__dirname,'src','scss')
const tsPath = join(__dirname,'src','ts')

const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const FixStyleOnlyEntriesPlugin = require('webpack-fix-style-only-entries')

module.exports = {
    entry: {
        'css/wp/nl_wp': join(scssPath,'wp/nl_wp.scss'),
        'css/wp/verify': join(scssPath,'wp/verify.scss'),
        'css/admin/nl_admin_add': join(scssPath,'admin/nl_admin_add.scss'),
        'css/admin/nl_admin_delete': join(scssPath,'admin/nl_admin_delete.scss'),
        'css/admin/nl_admin_log': join(scssPath,'admin/nl_admin_log.scss'),
        'css/admin/nl_admin_send': join(scssPath,'admin/nl_admin_send.scss'),
        'css/admin/nl_admin_settings': join(scssPath,'admin/nl_admin_settings.scss'),
        'js/wp/nl_wp': join(tsPath,'wp/nl_wp.ts'),
        'js/admin/nl_admin_add': join(tsPath,'admin/nl_admin_add.ts'),
        'js/admin/nl_admin_delete': join(tsPath,'admin/nl_admin_delete.ts'),
        'js/admin/nl_admin_log': join(tsPath, 'admin/nl_admin_log.ts'),
        'js/admin/nl_admin_send': join(tsPath,'admin/nl_admin_send.ts'),
        'js/admin/nl_admin_settings': join(tsPath,'admin/nl_admin_settings.ts'),
        'js/scripts/preunsubscribe': join(tsPath,'scripts/preunsubscribe.ts'),
        'js/create_users': join(tsPath,'create_users.ts')
    },
    output: {
        path: resolve(__dirname,'dist'),
        filename: '[name].js',
        clean: true
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/i,
                use: 'ts-loader',
                exclude: /node_modules/
            },
            {
                test: /\.(css|s[ac]ss)$/i,
                use: [MiniCssExtractPlugin.loader, 'css-loader','sass-loader'],
                exclude: /node_modules/
            }
        ]
    },
    plugins: [
        new FixStyleOnlyEntriesPlugin(),
        new MiniCssExtractPlugin({
            filename: '[name].css'
        })
    ],
    resolve: {
        extensions: ['.js','.ts','.tsx']
    }
}
