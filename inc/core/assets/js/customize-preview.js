// /**
//  * File customizer.js.
//  *
//  * Theme Customizer enhancements for a better user experience.
//  *
//  * Contains handlers to make Theme Customizer preview reload changes asynchronously.
//  */
//
// /**
//  *
//  * @param {string} controlId
//  * @param {string} selector
//  * @param {string||array} cssProperty
//  * @param {null} unit
//  */
// function colormagGenerateCSS( controlId, selector, cssProperty, unit = null ) {
//
// 	wp.customize( controlId, function( value ) {
//
// 		value.bind( function ( newValue ) {
// 			var cssText = '';
//
// 			jQuery( `style#${controlId}` ).remove();
//
// 			if ( null !== unit ) {
//
// 				if ( Array.isArray( cssProperty ) ) {
//
// 					cssProperty.forEach( function ( property ) {
// 						cssText += `${ property } : ${ newValue + unit };`;
// 					} );
// 				} else {
// 					cssText += `${ cssProperty } :  ${ newValue + unit };`;
// 				}
// 			} else {
// 				cssText += `${ cssProperty }: ${ newValue };`;
// 			}
//
// 			jQuery( 'head' ).append( `<style id="${ controlId }">${ selector }{ ${ cssText } }</style>` );
// 		} );
// 	} );
// }
//
// /**
//  * Control that returns either true or false.
//  *
//  * @param {string} controlId
//  * @param {string} selector
//  * @param {string} classes
//  * @param {boolean} removeOnTrue
//  */
// function colormagAddRemoveCSSClasses(  controlId, selector, classes, removeOnTrue = false  ) {
//
// 	wp.customize( controlId, function ( value ) {
//
// 		value.bind( function ( newValue ) {
//
// 			if ( removeOnTrue ) {
//
// 				if ( newValue ) {
// 					jQuery( selector ).removeClass( classes );
// 				} else {
// 					jQuery( selector ).addClass( classes );
// 				}
// 			} else {
//
// 				if ( newValue ) {
// 					jQuery( selector ).addClass( classes );
// 				} else {
// 					jQuery( selector ).removeClass( classes );
// 				}
// 			}
// 		} );
// 	} );
// }
//
// /**
//  * @param {string} controlId
//  * @param {string} selector
//  * @param {string} cssProperty
//  */
// function colormagGenerateDimensionCSS( controlId, selector, cssProperty  ) {
//
// 	wp.customize( controlId, function ( value ) {
//
// 		value.bind( function ( dimension ) {
// 			var topCSS = ( '' !== dimension.top ) ? dimension.top : 0,
// 				rightCSS = ( '' !== dimension.right ) ? dimension.right : 0,
// 				bottomCSS = ( '' !== dimension.bottom ) ? dimension.bottom : 0,
// 				leftCSS = ( '' !== dimension.left ) ? dimension.left : 0,
// 				unit = ( '' !== dimension.unit ) ? dimension.unit : 'px';
//
// 			jQuery( `style#${controlId}` ).remove();
//
// 			jQuery( 'head' ).append(
// 				`<style id="${ controlId }">${selector}{ ${ cssProperty } : ${ topCSS + unit + ' ' + rightCSS + unit + ' ' + bottomCSS + unit + ' ' + leftCSS + unit } }</style>`
// 			);
// 		} );
// 	} );
// }
//
// /**
//  * @param {string} controlId
//  * @param {string} selector
//  * @param {string} cssProperty
//  */
// function colormagGenerateSliderCSS( controlId, selector, cssProperty  ) {
//
// 	wp.customize( controlId, function ( value ) {
//
// 		value.bind( function ( slider ) {
//
// 			if ( 'string' === typeof slider ) {
// 				try {
// 					slider = JSON.parse( slider );
// 				} catch ( e ) {
// 					return;
// 				}
// 			}
// 			var cssText = '';
// 			var sizeCSS = slider.size;
// 			var unit = ( '' !== slider.unit ) ? slider.unit : 'px';
//
// 			jQuery( `style#${controlId}` ).remove();
//
// 			if ( null !== unit ) {
//
// 				if ( Array.isArray( cssProperty ) ) {
//
// 					cssProperty.forEach( function ( property ) {
// 						cssText += `${ property } : ${ sizeCSS + unit  };`;
// 					} );
// 				} else {
// 					cssText += `${ cssProperty } : ${ sizeCSS + unit  };`;
// 				}
// 			} else {
// 				cssText += `${ cssProperty } : ${ sizeCSS + unit  };`;
// 			}
//
// 			jQuery( 'head' ).append(
// 				`<style id="${ controlId }">${selector}{ ${ cssText } }</style>`
// 			);
// 		} );
// 	} );
// }
//
// /**
//  * @param {string} controlId
//  * @param {string} selector
//  * @param {string} cssProperty
//  */
// function colormagGenerateSliderWidthCss( controlId, selector, secondarySelector, cssProperty ) {
//
// 	wp.customize( controlId, function ( value ) {
//
// 		value.bind( function ( slider ) {
// 			if ( 'string' === typeof slider ) {
// 				try {
// 					slider = JSON.parse( slider );
// 				} catch ( e ) {
// 					return;
// 				}
// 			}
//
// 			var sizeCSS  = ( '' !== slider.size ) ? slider.size : 0;
// 			var secondaryCSS = 100 - sizeCSS;
// 			var unit       = ( '' !== slider.unit ) ? slider.unit : 'px';
//
// 			jQuery( `style#${controlId}` ).remove();
//
// 			jQuery( 'head' ).append(
// 				`<style id="${controlId}">${selector}{ ${cssProperty} : ${sizeCSS + unit} }
// 							${secondarySelector}{ ${cssProperty} : ${secondaryCSS + unit} }
// 							</style>`
// 			);
// 		} );
// 	} );
// }
//
// /**
//  * @param {string} controlId
//  * @param {string} selector
//  */
// function colormagGenerateBackgroundCSS( controlId, selector ) {
//
// 	wp.customize( controlId, function ( value ) {
//
// 		value.bind( function ( background ) {
// 			var css;
//
// 			jQuery( 'style#' + controlId ).remove();
//
// 			css = `${selector}{background-color: ${background['background-color']};background-image: url( ${background['background-image']} );background-attachment: ${background['background-attachment']};background-position: ${background['background-position']};background-size: ${background['background-size']};background-repeat: ${background['background-repeat']};}`;
//
// 			jQuery( 'head' ).append( `<style id="${ controlId }">${ css }</style>` );
// 		} );
// 	} );
// }
//
// /**
//  * @param {string} controlId
//  * @param {string} selector
//  */
// function colormagGenerateTypographyCSS( controlId, selector ) {
//
// 	wp.customize( controlId, function ( value ) {
//
// 		value.bind( function ( typography ) {
// 			var	link              = '',
// 				fontFamily = '',
// 				fontWeight = '',
// 				fontStyle = '',
// 				fontTransform = '',
// 				desktopFontSize = '',
// 				tabletFontSize = '',
// 				mobileFontSize = '',
// 				desktopLineHeight = '',
// 				tabletLineHeight = '',
// 				mobileLineHeight = '',
// 				desktopLetterSpacing = '',
// 				tabletLetterSpacing = '',
// 				mobileLetterSpacing = '';
//
// 			if ( 'object' == typeof typography ) {
//
// 				if ( undefined !== typography['font-size'] ) {
//
// 					if ( undefined !== typography['font-size']['desktop']['size'] && '' !== typography['font-size']['desktop']['size'] ) {
// 						desktopFontSize = typography['font-size']['desktop']['size'] + typography['font-size']['desktop']['unit'];
// 					}
//
// 					if ( undefined !== typography['font-size']['tablet']['size'] && '' !== typography['font-size']['tablet']['size'] ) {
// 						tabletFontSize = typography['font-size']['tablet']['size'] + typography['font-size']['tablet']['unit'];
// 					}
//
// 					if ( undefined !== typography['font-size']['mobile']['size'] && '' !== typography['font-size']['mobile']['size'] ) {
// 						mobileFontSize = typography['font-size']['mobile']['size'] + typography['font-size']['mobile']['unit'];
// 					}
// 				}
//
// 				if ( undefined !== typography['line-height'] ) {
//
// 					if ( undefined !== typography['line-height']['desktop']['size'] && '' !== typography['line-height']['desktop']['size'] ) {
// 						const desktopLineHeightUnit = ('-' !== typography['line-height']['desktop']['unit']) ? typography['line-height']['desktop']['unit'] : '';
// 						desktopLineHeight = typography['line-height']['desktop']['size'] + desktopLineHeightUnit;
// 					}
//
// 					if ( undefined !== typography['line-height']['tablet']['size'] && '' !== typography['line-height']['tablet']['size'] ) {
// 						const tabletLineHeightUnit = ('-' !== typography['line-height']['tablet']['unit']) ? typography['line-height']['tablet']['unit'] : '';
// 						tabletLineHeight = typography['line-height']['tablet']['size'] + tabletLineHeightUnit;
// 					}
//
// 					if ( undefined !== typography['line-height']['mobile']['size'] && '' !== typography['line-height']['mobile']['size'] ) {
// 						const mobileLineHeightUnit = ('-' !== typography['line-height']['mobile']['unit']) ? typography['line-height']['mobile']['unit'] : '';
// 						mobileLineHeight = typography['line-height']['mobile']['size'] + mobileLineHeightUnit;
// 					}
// 				}
//
// 				if ( undefined !== typography['letter-spacing'] ) {
//
// 					if ( undefined !== typography['letter-spacing']['desktop']['size'] && '' !== typography['letter-spacing']['desktop']['size'] ) {
// 						const desktopLetterSpacingUnit = ('-' !== typography['letter-spacing']['desktop']['unit']) ? typography['letter-spacing']['desktop']['unit'] : '';
// 						desktopLetterSpacing = typography['letter-spacing']['desktop']['size'] + desktopLetterSpacingUnit;
// 					}
//
// 					if ( undefined !== typography['letter-spacing']['tablet']['size'] && '' !== typography['letter-spacing']['tablet']['size'] ) {
// 						const tabletLetterSpacingUnit = ('-' !== typography['letter-spacing']['tablet']['unit']) ? typography['letter-spacing']['tablet']['unit'] : '';
// 						tabletLetterSpacing = typography['letter-spacing']['tablet']['size'] + tabletLetterSpacingUnit;
// 					}
//
// 					if ( undefined !== typography['letter-spacing']['mobile']['size'] && '' !== typography['letter-spacing']['mobile']['size'] ) {
// 						const mobileLetterSpacingUnit = ('-' !== typography['letter-spacing']['mobile']['unit']) ? typography['letter-spacing']['mobile']['unit'] : '';
// 						mobileLetterSpacing = typography['letter-spacing']['mobile']['size'] + mobileLetterSpacingUnit;
// 					}
// 				}
//
// 				if ( undefined !== typography['font-family'] && '' !== typography['font-family'] ) {
// 					fontFamily = typography['font-family'].split(",")[0];
// 					fontFamily = fontFamily.replace(/'/g, '');
//
// 					if ( fontFamily.includes( 'default' ) || fontFamily.includes( '-apple-system' )  ) {
// 						fontFamily = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif';
// 					} else if ( fontFamily.includes( 'Monaco' ) ) {
// 						fontFamily = 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace';
// 					} else {
// 						link = `<link id="${ controlId }" href="https://fonts.googleapis.com/css?family=${ fontFamily }" rel="stylesheet">`;
// 					}
// 				}
//
// 				if ( undefined !== typography['font-weight'] && '' !== typography['font-weight'] ) {
//
// 					if ( colormagIsNumeric( typography['font-weight'] ) ) {
// 						fontWeight = parseInt( typography['font-weight'] );
// 					} else {
// 						fontWeight = 'regular' != typography['font-weight'] ? typography['font-weight'] : 'normal';
// 					}
// 				}
//
// 				if ( undefined !== typography['font-style'] && '' !== typography['font-style'] ) {
// 					fontStyle = typography['font-style'];
// 				}
//
// 				if ( undefined !== typography['text-transform'] && '' !== typography['text-transform'] ) {
// 					fontTransform = typography['text-transform'];
// 				}
//
// 				jQuery( 'style#' + controlId ).remove();
// 				jQuery('link#' + controlId).remove();
//
// 				jQuery('head').append(
// 					`<style id="${ controlId }">
// 					${ selector } {
// 						font-family: ${ fontFamily };
// 						font-weight: ${ fontWeight };
// 						font-style: ${ fontStyle };
// 						text-transform: ${ fontTransform };
// 						font-size: ${ desktopFontSize };
// 						line-height: ${ desktopLineHeight };
// 						letter-spacing: ${ desktopLetterSpacing };
// 					}
// 					@media (max-width: 768px) {
// 						${ selector } {
// 							font-size: ${ tabletFontSize };
// 							line-height: ${ tabletLineHeight };
// 							letter-spacing: ${ tabletLetterSpacing };
// 						}
// 					}
// 					@media (max-width: 600px) {
// 						${ selector }{
// 							font-size: ${ mobileFontSize };
// 							line-height:${ mobileLineHeight };
// 							letter-spacing: ${ mobileLetterSpacing };
// 						}
// 					}
// 				</style>${ link }`
// 				);
// 			}
// 		} );
// 	} );
// }
//
// /**
//  * @param {string} str
//  * @returns {boolean}
//  */
// function colormagIsNumeric( str ) {
// 	var matches;
//
// 	if ( 'string' !== typeof str ) {
// 		return false;
// 	}
//
// 	matches = str.match(/\d+/g);
//
// 	return null !== matches;
// }

(function ($) {
	function colormagColorPalette(v, to) {
		let styles = '';
		Object.entries(to.colors).forEach(([k, v]) => {
			styles += `--${k}:${v};`;
		});
		v = `:root {${styles}}`;
		return v;
	}

	function colormagGenerateCommonCSS(selector, property, value) {
		return `${selector} {${property}:${value};}`;
	}

	function colormagGenerateSlidebarWidthCSS(
		selector,
		secondarySelector,
		property,
		value,
	) {
		let sidebarCss = value.size;
		let primaryCss = 100 - value.size;
		let css = '';
		css = `${selector} {${property}: ${sidebarCss}${value.unit};}`;
		css += `${secondarySelector} {${property}: ${primaryCss}${value.unit};}`;

		return css;
	}

	function colormagGenerateSliderCSS(selector, property, value) {
		return `${selector} {${property}: ${value.size}${value.unit};}`;
	}

	function colormagGenerateBackgroundCSS(selector, value) {
		let backgroundColor = value['background-color'],
			backgroundImage = value['background-image'],
			backgroundAttachment = value['background-attachment'],
			backgroundPosition = value['background-position'],
			backgroundSize = value['background-size'],
			backgroundRepeat = value['background-repeat'];

		return `${selector}{background-color: ${backgroundColor};background-image: url( ${backgroundImage} );background-attachment: ${backgroundAttachment};background-position: ${backgroundPosition};background-size: ${backgroundSize};background-repeat: ${backgroundRepeat};}`;
	}

	/**
	 * @param {string} str
	 * @returns {boolean}
	 */
	function colormagIsNumeric(str) {
		var matches;

		if ('string' !== typeof str) {
			return false;
		}

		matches = str.match(/\d+/g);

		return null !== matches;
	}

	function colormagGenerateTypographyCSS(controlId, selector, typography) {
		let css = '';
		var link = '',
			fontFamily = '',
			fontWeight = '',
			fontStyle = '',
			fontTransform = '',
			desktopFontSize = '',
			tabletFontSize = '',
			mobileFontSize = '',
			desktopLineHeight = '',
			tabletLineHeight = '',
			mobileLineHeight = '',
			desktopLetterSpacing = '',
			tabletLetterSpacing = '',
			mobileLetterSpacing = '';

		if ('object' == typeof typography) {
			if (undefined !== typography['font-size']) {
				if (
					undefined !== typography['font-size']['desktop']['size'] &&
					'' !== typography['font-size']['desktop']['size']
				) {
					desktopFontSize =
						typography['font-size']['desktop']['size'] +
						typography['font-size']['desktop']['unit'];
				}

				if (
					undefined !== typography['font-size']['tablet']['size'] &&
					'' !== typography['font-size']['tablet']['size']
				) {
					tabletFontSize =
						typography['font-size']['tablet']['size'] +
						typography['font-size']['tablet']['unit'];
				}

				if (
					undefined !== typography['font-size']['mobile']['size'] &&
					'' !== typography['font-size']['mobile']['size']
				) {
					mobileFontSize =
						typography['font-size']['mobile']['size'] +
						typography['font-size']['mobile']['unit'];
				}
			}

			if (undefined !== typography['line-height']) {
				if (
					undefined !== typography['line-height']['desktop']['size'] &&
					'' !== typography['line-height']['desktop']['size']
				) {
					const desktopLineHeightUnit =
						'-' !== typography['line-height']['desktop']['unit']
							? typography['line-height']['desktop']['unit']
							: '';
					desktopLineHeight =
						typography['line-height']['desktop']['size'] +
						desktopLineHeightUnit;
				}

				if (
					undefined !== typography['line-height']['tablet']['size'] &&
					'' !== typography['line-height']['tablet']['size']
				) {
					const tabletLineHeightUnit =
						'-' !== typography['line-height']['tablet']['unit']
							? typography['line-height']['tablet']['unit']
							: '';
					tabletLineHeight =
						typography['line-height']['tablet']['size'] + tabletLineHeightUnit;
				}

				if (
					undefined !== typography['line-height']['mobile']['size'] &&
					'' !== typography['line-height']['mobile']['size']
				) {
					const mobileLineHeightUnit =
						'-' !== typography['line-height']['mobile']['unit']
							? typography['line-height']['mobile']['unit']
							: '';
					mobileLineHeight =
						typography['line-height']['mobile']['size'] + mobileLineHeightUnit;
				}
			}

			if (undefined !== typography['letter-spacing']) {
				if (
					undefined !== typography['letter-spacing']['desktop']['size'] &&
					'' !== typography['letter-spacing']['desktop']['size']
				) {
					const desktopLetterSpacingUnit =
						'-' !== typography['letter-spacing']['desktop']['unit']
							? typography['letter-spacing']['desktop']['unit']
							: '';
					desktopLetterSpacing =
						typography['letter-spacing']['desktop']['size'] +
						desktopLetterSpacingUnit;
				}

				if (
					undefined !== typography['letter-spacing']['tablet']['size'] &&
					'' !== typography['letter-spacing']['tablet']['size']
				) {
					const tabletLetterSpacingUnit =
						'-' !== typography['letter-spacing']['tablet']['unit']
							? typography['letter-spacing']['tablet']['unit']
							: '';
					tabletLetterSpacing =
						typography['letter-spacing']['tablet']['size'] +
						tabletLetterSpacingUnit;
				}

				if (
					undefined !== typography['letter-spacing']['mobile']['size'] &&
					'' !== typography['letter-spacing']['mobile']['size']
				) {
					const mobileLetterSpacingUnit =
						'-' !== typography['letter-spacing']['mobile']['unit']
							? typography['letter-spacing']['mobile']['unit']
							: '';
					mobileLetterSpacing =
						typography['letter-spacing']['mobile']['size'] +
						mobileLetterSpacingUnit;
				}
			}

			if (
				undefined !== typography['font-family'] &&
				'' !== typography['font-family']
			) {
				fontFamily = typography['font-family'].split(',')[0];
				fontFamily = fontFamily.replace(/'/g, '');

				if (
					fontFamily.includes('default') ||
					fontFamily.includes('-apple-system')
				) {
					fontFamily =
						'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif';
				} else if (fontFamily.includes('Monaco')) {
					fontFamily =
						'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace';
				} else {
					link = `<link id="${controlId}" href="https://fonts.googleapis.com/css?family=${fontFamily}" rel="stylesheet">`;
				}
			}

			if (
				undefined !== typography['font-weight'] &&
				'' !== typography['font-weight']
			) {
				if (colormagIsNumeric(typography['font-weight'])) {
					fontWeight = parseInt(typography['font-weight']);
				} else {
					fontWeight =
						'regular' != typography['font-weight']
							? typography['font-weight']
							: 'normal';
				}
			}

			if (
				undefined !== typography['font-style'] &&
				'' !== typography['font-style']
			) {
				fontStyle = typography['font-style'];
			}

			if (
				undefined !== typography['text-transform'] &&
				'' !== typography['text-transform']
			) {
				fontTransform = typography['text-transform'];
			}

			jQuery('link#' + controlId).remove();

			css = `${selector} {
						font-family: ${fontFamily};
						font-weight: ${fontWeight};
						font-style: ${fontStyle};
						text-transform: ${fontTransform};
						font-size: ${desktopFontSize};
						line-height: ${desktopLineHeight};
						letter-spacing: ${desktopLetterSpacing};
					}`;

			css += `@media (max-width: 768px) {
						${selector} {
							font-size: ${tabletFontSize};
							line-height: ${tabletLineHeight};
							letter-spacing: ${tabletLetterSpacing};
						}
					}`;

			css += `@media (max-width: 600px) {
						${selector}{
							font-size: ${mobileFontSize};
							line-height:${mobileLineHeight};
							letter-spacing: ${mobileLetterSpacing};
						}
					}`;

			jQuery('head').append(link);

			return css;
		}

		return css;
	}

	function colormagGenerateDimnesionCSS(selector, property, value) {
		let topCSS = value.top ? value.top : 0,
			rightCSS = value.right ? value.right : 0,
			bottomCSS = value.bottom ? value.bottom : 0,
			leftCSS = value.left ? value.left : 0,
			unit = value.unit ? value.unit : 'px';

		return `${selector}{ ${property} : ${topCSS + unit + ' ' + rightCSS + unit + ' ' + bottomCSS + unit + ' ' + leftCSS + unit}}`;
	}

	wp.hooks.addFilter(
		'customind.dynamic.css',
		'customind',
		function (css, value, id) {
			switch (id) {
				case 'colormag_color_palette':
					css = colormagColorPalette(css, value);
					break;

				case 'colormag_base_color':
					css = colormagGenerateCommonCSS('body', 'color', value);
					break;

				case 'colormag_link_color':
					css = colormagGenerateCommonCSS(
						'.cm-entry-summary a',
						'color',
						value,
					);
					break;

				case 'colormag_link_hover_color':
					css = colormagGenerateCommonCSS(
						`.cm-entry-summary a:hover,.pagebuilder-content a:hover, .pagebuilder-content a:hover`,
						'color',
						value,
					);
					break;

				case 'colormag_inside_container_background':
					css = colormagGenerateBackgroundCSS('.cm-content', value);
					break;

				case 'colormag_outside_container_background':
					css = colormagGenerateBackgroundCSS('body', value);
					break;

				// case 'colormag_sidebar_width':
				// 	css = colormagGenerateSlidebarWidthCSS('.cm-primary', 'max-width', value);
				// 	break;

				case 'colormag_base_typography':
					css = colormagGenerateTypographyCSS(
						id,
						`body, button, input, select, textarea, blockquote p, .entry-meta, .cm-entry-button, dl, .previous a, .next a, .nav-previous a, .nav-next a, #respond h3#reply-title #cancel-comment-reply-link, #respond form input[type="text"], #respond form textarea, .cm-secondary .widget, .cm-error-404 .widget, .cm-entry-summary p`,
						value,
					);
					break;

				case 'colormag_headings_typography':
					css = colormagGenerateTypographyCSS(
						id,
						'h1 ,h2, h3, h4, h5, h6',
						value,
					);
					break;

				case 'colormag_h1_typography':
					css = colormagGenerateTypographyCSS(id, 'h1', value);
					break;

				case 'colormag_h2_typography':
					css = colormagGenerateTypographyCSS(id, 'h2', value);
					break;

				case 'colormag_h3_typography':
					css = colormagGenerateTypographyCSS(id, 'h3', value);
					break;

				case 'colormag_h4_typography':
					css = colormagGenerateTypographyCSS(id, 'h4', value);
					break;

				case 'colormag_h5_typography':
					css = colormagGenerateTypographyCSS(id, 'h5', value);
					break;

				case 'colormag_h6_typography':
					css = colormagGenerateTypographyCSS(id, 'h6', value);
					break;

				case 'colormag_button_color':
					css = colormagGenerateCommonCSS(
						'.colormag-button, input[type="reset"], input[type="button"], input[type="submit"], button, .cm-entry-button span, .wp-block-button .wp-block-button__link',
						'color',
						value,
					);
					break;

				case 'colormag_button_hover_color':
					css = colormagGenerateCommonCSS(
						'.colormag-button:hover, input[type="reset"]:hover, input[type="button"]:hover, input[type="submit"]:hover, button:hover, .cm-entry-button span:hover, .wp-block-button .wp-block-button__link:hover',
						'color',
						value,
					);
					break;

				case 'colormag_button_background_color':
					css = colormagGenerateCommonCSS(
						'.colormag-button, input[type="reset"], input[type="button"], input[type="submit"], button, .cm-entry-button span, .wp-block-button .wp-block-button__link',
						'background-color',
						value,
					);
					break;

				case 'colormag_button_background_hover_color':
					css = colormagGenerateCommonCSS(
						'.colormag-button:hover, input[type="reset"]:hover, input[type="button"]:hover, input[type="submit"]:hover, button:hover, .cm-entry-button span:hover, .wp-block-button .wp-block-button__link:hover',
						'background-color',
						value,
					);
					break;

				case 'colormag_button_dimension_padding':
					css = colormagGenerateDimnesionCSS(
						'.colormag-button, input[type="reset"], input[type="button"], input[type="submit"], button, .cm-entry-button span, .wp-block-button .wp-block-button__link',
						'padding',
						value,
					);
					break;

				case 'colormag_button_border_radius':
					css = colormagGenerateSliderCSS(
						'.colormag-button, input[type="reset"], input[type="button"], input[type="submit"], button, .cm-entry-button span, .wp-block-button .wp-block-button__link',
						'border-radius',
						value,
					);
					break;
			}
			return css;
		},
	);

	wp.hooks.addAction(
		'customind.change.colormag_color_palette',
		'customind',
		(...args) => {
			console.log(args);
		},
	);

	wp.hooks.addAction(
		'customind.change.colormag_container_layout',
		'customind',
		(value) => {
			if ('wide' === value) {
				$('body')
					.removeClass('zak-container--boxed')
					.addClass('zak-container--wide');
			} else if ('boxed' === value) {
				$('body')
					.removeClass('zak-container--wide')
					.addClass('zak-container--boxed');
			}
		},
	);

	wp.hooks.addAction(
		'customind.change.colormag_content_area_layout',
		'customind',
		(value) => {
			if ('bordered' === value) {
				$('body')
					.removeClass('zak-content-area--boxed')
					.addClass('zak-content-area--bordered');
			} else if ('boxed' === value) {
				$('body')
					.removeClass('zak-content-area--bordered')
					.addClass('zak-content-area--boxed');
			}
		},
	);

	wp.hooks.addAction(
		'customind.change.colormag_page_header_layout',
		'customind',
		(value) => {
			if ('style-1' === value) {
				$('.zak-page-header')
					.removeClass('zak-style-2')
					.removeClass('zak-style-3')
					.removeClass('zak-style-4')
					.removeClass('zak-style-5')
					.addClass('zak-style-1');
			} else if ('style-2' === value) {
				$('.zak-page-header')
					.removeClass('zak-style-1')
					.removeClass('zak-style-3')
					.removeClass('zak-style-4')
					.removeClass('zak-style-5')
					.addClass('zak-style-2');
			} else if ('style-3' === value) {
				$('.zak-page-header')
					.removeClass('zak-style-1')
					.removeClass('zak-style-2')
					.removeClass('zak-style-4')
					.removeClass('zak-style-5')
					.addClass('zak-style-3');
			} else if ('style-4' === value) {
				$('.zak-page-header')
					.removeClass('zak-style-1')
					.removeClass('zak-style-2')
					.removeClass('zak-style-3')
					.removeClass('zak-style-5')
					.addClass('zak-style-4');
			} else if ('style-5' === value) {
				$('.zak-page-header')
					.removeClass('zak-style-1')
					.removeClass('zak-style-2')
					.removeClass('zak-style-3')
					.removeClass('zak-style-4')
					.addClass('zak-style-5');
			}
		},
	);

	wp.hooks.addAction(
		'customind.change.colormag_footer_bar_style',
		'customind',
		(value) => {
			if ('style-1' === value) {
				$('.zak-footer-bar').removeClass('zak-style-2').addClass('zak-style-1');
			} else if ('style-2' === value) {
				$('.zak-footer-bar').removeClass('zak-style-1').addClass('zak-style-2');
			}
		},
	);
})(jQuery);
