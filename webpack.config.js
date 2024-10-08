const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const fs = require('fs');

module.exports = {
  mode: 'development', // Switch to 'production' for production-ready minified CSS
  entry: './sass/custom.sass', // Entry point for Sass
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/, // Match Sass, SCSS, and CSS files
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader', // Translates CSS into CommonJS
          'sass-loader', // Compiles Sass to CSS
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      // Write compiled CSS to a temporary file
      filename: 'compiled-sass.css',
    }),
    // Append compiled Sass to the existing style.css
    {
      apply: (compiler) => {
        compiler.hooks.afterEmit.tap('AppendToFilePlugin', () => {
          const compiledCSS = fs.readFileSync(
            path.resolve(__dirname, 'dist/compiled-sass.css'),
            'utf8'
          );
          const existingCSS = fs.readFileSync(
            path.resolve(__dirname, 'style.css'),
            'utf8'
          );

          // Combine existing CSS with compiled Sass
          const mergedCSS = existingCSS + '\n' + compiledCSS;

          // Write the merged CSS back to style.css
          fs.writeFileSync(path.resolve(__dirname, 'style.css'), mergedCSS);
        });
      },
    },
  ],
  watch: true, // Automatically recompile and append when changes are detected
};
