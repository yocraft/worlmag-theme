const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  mode: 'development', // or 'production' for optimized CSS
  entry: './sass/custom.sass', // Entry point for your Sass file
  output: {
    path: path.resolve(__dirname, 'dist'), // Output directory for the compiled CSS
    filename: 'dummy.js', // Dummy JS output, not used here
  },
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/, // Regex to match .sass, .scss, and .css files
        use: [
          MiniCssExtractPlugin.loader, // Extracts the CSS into a separate file
          'css-loader', // Translates CSS into CommonJS
          'sass-loader', // Compiles Sass into CSS
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '../custom.css', // Output file for the compiled Sass (relative to the theme root)
    }),
  ],
  watch: true, // Enable file watching for automatic recompilation
};
