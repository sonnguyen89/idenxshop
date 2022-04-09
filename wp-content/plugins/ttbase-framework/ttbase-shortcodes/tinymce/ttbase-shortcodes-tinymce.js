(function() {
	tinymce.PluginManager.add( 'ttbase_framework_shortcodes_mce_button', function( editor, url ) {
		editor.addButton( 'ttbase_framework_shortcodes_mce_button', {
			text: 'TTBase Shortcodes',
			type: 'menubutton',
			icon: false,
			menu: [
					
				/** Elements **/
				{
					text: 'Elements',
					menu: [
						
						/* Buttons */
						{
							text: 'Button',
							onclick: function() {
								editor.windowManager.open( {
									title: 'TTBase Shortcodes - Insert Button',
									body: [

									// Button Text
									{
										type: 'textbox',
										name: 'buttonTitle',
										label: 'Button: Title',
										value: 'Button'
									},

									// Button URL
									{
										type: 'textbox',
										name: 'buttonUrl',
										label: 'Button: URL',
										value: '#'
									},

									// Button Style
									{
										type: 'listbox',
										name: 'buttonStyle',
										label: 'Button: Style',
										values: [
											{text: 'Style 1', value: 'style-1'},
											{text: 'Style 2', value: 'style-2'}
										]
									},

									// Button Size
									{
										type: 'listbox',
										name: 'buttonSize',
										label: 'Button: Size',
										values: [
											{text: 'Default', value: ''},
											{text: 'Small', value: 'btn-small'},
											{text: 'Medium', value: 'bt-medium'},
											{text: 'Large', value: 'btn-large'}
										]
									},
									// Button Width
									{
										type: 'listbox',
										name: 'buttonWidth',
										label: 'Button: Set width to 100%?',
										values: [
											{text: 'No', value: ''},
											{text: 'Yes', value: 'true'}
										]
									},

									// Button Link Target
									{
										type: 'listbox',
										name: 'buttonLinkTarget',
										label: 'Button: Link Target',
										values: [
											{text: 'Self', value: 'self'},
											{text: 'Blank', value: 'blank'}
										]
									},

									// Button Rel
									{
										type: 'listbox',
										name: 'buttonRel',
										label: 'Button: Rel',
										values: [
											{text: 'None', value: ''},
											{text: 'Nofollow', value: 'nofollow'}
										]
									},
                                    // Button Style
									{
										type: 'listbox',
										name: 'buttonIconFont',
										label: 'Button: Icon Font',
										values: [
											{text: 'Streamline', value: 'streamline'},
											{text: 'Icons Mind', value: 'iconsmind'},
											{text: 'Font Awesome', value: 'fontawesome'}
										]
									},
									// Button Left Icon Streamline
									{
										type: 'textbox',
										name: 'buttonLeftIconStreamline',
										label: 'Button: Left Icon (Streamline Class Name)',
										value: ''
									},

									// Button Right Icon Streamline
									{
										type: 'textbox',
										name: 'buttonRightIconStreamline',
										label: 'Button: Right Icon (Streamline Class Name)',
										value: ''
									},
									// Button Left Icon Icons Mind
									{
										type: 'textbox',
										name: 'buttonLeftIconIM',
										label: 'Button: Left Icon (Icons Mind Class Name)',
										value: ''
									},

									// Button Right Icon Icons Mind
									{
										type: 'textbox',
										name: 'buttonRightIconIM',
										label: 'Button: Right Icon (Icons Mind Class Name)',
										value: ''
									},
									// Button Left Icon Font Awesome
									{
										type: 'textbox',
										name: 'buttonLeftIconFontAwesome',
										label: 'Button: Left Icon (FontAwesome Class Name)',
										value: ''
									},

									// Button Right Icon Font Awesome
									{
										type: 'textbox',
										name: 'buttonRightIconFontAwesome',
										label: 'Button: Right Icon (FontAwesome Class Name)',
										value: ''
									}],
									onsubmit: function( e ) {
										editor.insertContent('[ttbase_button url="' + e.data.buttonUrl + '" style="' + e.data.buttonStyle + '" size="' + e.data.buttonSize + '" width_100="' + e.data.buttonWidth + '" target="' + e.data.buttonLinkTarget + '" rel="' + e.data.buttonRel + '" icon_font="' + e.data.buttonIconFont + '" icon_left_sl="' + e.data.buttonLeftIconStreamline + '" icon_right_sl="' + e.data.buttonRightIconStreamline + '"icon_left_im="' + e.data.buttonLeftIconIM + '" icon_right_im="' + e.data.buttonRightIconIM + '" icon_left_fa="' + e.data.buttonLeftIconFontAwesome + '" icon_right_fa="' + e.data.buttonRightIconFontAwesome + '" title="' + e.data.buttonTitle + '"]');
									}
								});
							}
						}, // End button

                        /* Callout */
                        {
                            text: 'Callout',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'TTBase Shortcodes - Insert Callout',
                                    body: [

                                        // Callout FadeIn
                                        {
                                            type: 'listbox',
                                            name: 'calloutFadeIn',
                                            label: 'FadeIn',
                                            values: [
                                                {text: 'No', value: 'false'},
                                                {text: 'Yes', value: 'true'}
                                            ]
                                        },

                                        // Callout Button Text
                                        {
                                            type: 'textbox',
                                            name: 'calloutButtonText',
                                            label: 'Button: Text',
                                            value: 'Button'
                                        },

                                        // Callout Button URL
                                        {
                                            type: 'textbox',
                                            name: 'calloutButtonUrl',
                                            label: 'Button: URL',
                                            value: '#'
                                        },

                                        // Callout Button Style
                                        {
                                            type: 'listbox',
                                            name: 'calloutButtonStyle',
                                            label: 'Button: Style',
                                            values: [
                                                {text: 'Style 1', value: 'style-1'},
                                                {text: 'Style 2', value: 'style-2'}
                                            ]
                                        },

                                        // Callout Button Size
                                        {
                                            type: 'listbox',
                                            name: 'calloutButtonSize',
                                            label: 'Button: Size',
                                            values: [
                                                {text: 'Default', value: 'default'},
                                                {text: 'Small', value: 'btn-small'},
                                                {text: 'Medium', value: 'btn-medium'},
                                                {text: 'Large', value: 'btn-large'}
                                            ]
                                        },

                                        // Callout Button Link Target
                                        {
                                            type: 'listbox',
                                            name: 'calloutButtonLinkTarget',
                                            label: 'Button: Link Target',
                                            values: [
                                                {text: 'Self', value: 'self'},
                                                {text: 'Blank', value: 'blank'}
                                            ]
                                        },

                                        // Callout Button Rel
                                        {
                                            type: 'listbox',
                                            name: 'calloutButtonRel',
                                            label: 'Button: Rel',
                                            values: [
                                                {text: 'None', value: ''},
                                                {text: 'Nofollow', value: 'nofollow'}
                                            ]
                                        },

                                        // Callout Button Left Icon
                                        {
                                            type: 'textbox',
                                            name: 'calloutButtonLeftIcon',
                                            label: 'Button: Left Icon (FontAwesome Class Name)',
                                            value: ''
                                        },

                                        // Callout Button Right Icon
                                        {
                                            type: 'textbox',
                                            name: 'calloutButtonRightIcon',
                                            label: 'Button: Right Icon (FontAwesome Class Name)',
                                            value: ''
                                        },

                                        // Callout Content
                                        {
                                            type: 'textbox',
                                            name: 'calloutContent',
                                            label: 'Content',
                                            value: 'Callout Content',
                                            multiline: true,
                                            minWidth: 300,
                                            minHeight: 100
                                        }

                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent('[ttbase_callout fade_in="' + e.data.calloutFadeIn + '" button_text="' + e.data.calloutButtonText + '" button_url="' + e.data.calloutButtonUrl + '" button_style="' + e.data.calloutButtonStyle + '" button_size="' + e.data.calloutButtonSize + '" button_target="' + e.data.calloutButtonLinkTarget + '" button_rel="' + e.data.calloutButtonRel + '" button_icon_left="' + e.data.calloutButtonLeftIcon + '" button_icon_right="' + e.data.calloutButtonRightIcon + '"]' + e.data.calloutContent + '[/ttbase_callout]');
                                    }
                                });
                            }
                        }, // End callout

                        /* Image with Content */
                        {
                            text: 'Image with Content',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'TTBase Shortcodes - Insert Image with Content',
                                    body: [

                                        // Image with Content Layout
                                        {
                                            type: 'listbox',
                                            name: 'imageContentLayout',
                                            label: 'Layout',
                                            values: [
                                                {text: 'Image with inner Content Left', value: 'offscreen-left'},
                                                {text: 'Image with inner Content Right', value: 'offscreen-right'},
                                                {text: 'Image with shadow Left', value: 'shadow-left'},
                                                {text: 'Image with shadow Right', value: 'shadow-right'},
                                                {text: 'Boxed Image Left', value: 'box-left'},
                                                {text: 'Boxed Image Right', value: 'box-right'}
                                            ]
                                        },

                                        // Image
                                        {
                                            type: 'textbox',
                                            name: 'imageContentImage',
                                            label: 'Image',
                                            value: 'IMAGE_URL'
                                        },
                                        // Content Background Color
                                        {
                                            type: 'textbox',
                                            name: 'imageContentColor',
                                            label: 'Content Hex Background Color',
                                            value: ''
                                        },
                                        // Content
                                        {
                                            type: 'textbox',
                                            multiline: true,
                                            minWidth: 300,
                                            minHeight: 100,
                                            name: 'imageWithContentContent',
                                            label: 'Content',
                                            value: 'This is a intro text.'
                                        }
                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent('[ttbase_content_image background_color="' + e.data.imageContentColor + '" layout="' + e.data.imageContentLayout + '" image="' + e.data.imageContentImage + '"]' + e.data.imageWithContentContent + '[/ttbase_content_image]');
                                    }
                                });
                            }
                        }, // End Image with Content

                        /* Counter */
                        {
                            text: 'Counter',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'TTBase Shortcodes - Insert Counter',
                                    body: [

                                        // Counter Number
                                        {
                                            type: 'textbox',
                                            name: 'counterNumber',
                                            label: 'Number',
                                            value: '100'
                                        },

                                        // Counter Title
                                        {
                                            type: 'textbox',
                                            name: 'counterTitle',
                                            label: 'Title',
                                            value: ''
                                        },

                                        // Counter Number Color
                                        {
                                            type: 'textbox',
                                            name: 'counterNumberColor',
                                            label: 'Number Hex Color',
                                            value: '#3cb087'
                                        },

                                        // Counter Title Color
                                        {
                                            type: 'textbox',
                                            name: 'counterTitleColor',
                                            label: 'Title Hex Color',
                                            value: '#1e2221'
                                        },

                                        // Counter Background Color
                                        {
                                            type: 'textbox',
                                            name: 'counterBackgroundColor',
                                            label: 'Background Hex Color',
                                            value: '#ffffff'
                                        },
                                        // Counter Border Color
                                        {
                                            type: 'textbox',
                                            name: 'counterBorderColor',
                                            label: 'Border Hex Color',
                                            value: '#dfdfdf'
                                        }
                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent('[ttbase_counter number="' + e.data.counterNumber + '" title="' + e.data.counterTitle + '" color="' + e.data.counterNumberColor + '" title_color="' + e.data.counterTitleColor + '" background_color="' + e.data.counterBackgroundColor + '" border_color="' + e.data.counterBorderColor + '"]' );
                                    }
                                });
                            }
                        }, // End Counter

                        /* Google Map */
                        {
                            text: 'Google Map',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'TTBase Shortcodes - Insert Google Map',
                                    body: [
                                        // Google Map Height
                                        {
                                            type: 'textbox',
                                            name: 'gmapHeight',
                                            label: 'Height',
                                            value: '300'
                                        },

                                        // Google Map Type
                                        {
                                            type: 'listbox',
                                            name: 'gmapType',
                                            label: 'Type',
                                            values: [
                                                {text: 'Road Map', value: 'ROADMAP'},
                                                {text: 'Satellite', value: 'SATELLITE'},
                                                {text: 'Hybrid', value: 'HYBRID'},
                                                {text: 'Terrain', value: 'TERRAIN'},
                                            ]
                                        },

                                        // Google Map Style
                                        {
                                            type: 'listbox',
                                            name: 'gmapStyle',
                                            label: 'Style',
                                            values: [
                                                {text: 'Shades of Grey', value: '1'},
                                                {text: 'Greyscale', value: '2'},
                                                {text: 'Light Gray', value: '3'},
                                                {text: 'Midnight Commander', value: '4'},
                                                {text: 'Blue water', value: '5'},
                                                {text: 'Icy Blue', value: '6'},
                                                {text: 'Bright and Bubbly', value: '7'},
                                                {text: 'Pale Dawn', value: '8'},
                                                {text: 'Paper', value: '9'},
                                                {text: 'Blue Essence', value: '10'},
                                                {text: 'Apple Maps-esque', value: '11'},
                                                {text: 'Subtle Grayscale', value: '12'},
                                                {text: 'Retro', value: '13'},
                                                {text: 'Hopper', value: '14'},
                                                {text: 'Red Hues', value: '15'},
                                                {text: 'Ultra Light with labels', value: '16'},
                                                {text: 'Unsaturated Browns', value: '17'},
                                                {text: 'Light Dream', value: '18'},
                                                {text: 'Neutral Blue', value: '19'},
                                                {text: 'MapBox', value: '20'}
                                            ]
                                        },
                                        // Google Map Latitude
                                        {
                                            type: 'textbox',
                                            name: 'gmapLat',
                                            label: 'Latitude',
                                            value: '51.4946416'
                                        },

                                        // Google Map Longitude
                                        {
                                            type: 'textbox',
                                            name: 'gmapLng',
                                            label: 'Longitude',
                                            value: '-0.172699'
                                        },

                                        // Google Map Zoom
                                        {
                                            type: 'textbox',
                                            name: 'gmapZoom',
                                            label: 'Zoom',
                                            value: '12'
                                        },

                                        // Google Map Markers
                                        {
                                            type: 'listbox',
                                            name: 'gmapMarker',
                                            label: 'Markers',
                                            values: [
                                                {text: 'Yes', value: 'yes'},
                                                {text: 'No', value: 'no'}
                                            ]
                                        },
                                        // Google Map Api Key
                                        {
                                            type: 'textbox',
                                            name: 'gmapApiKey',
                                            label: 'Api Key',
                                            value: ''
                                        },

                                    ],
                                    onsubmit: function( e ) {
                                        editor.insertContent('[ttbase_google_map map_type="' + e.data.gmapType + '" style="' + e.data.gmapStyle + '" lat="' + e.data.gmapLat + '" lng="' + e.data.gmapLng + '" height="' + e.data.gmapHeight + '" marker="' + e.data.gmapMarker + '" zoom="' + e.data.gmapZoom + '" api_key="' + e.data.gmapApiKey + '"]');
                                    }
                                });
                            }
                        }, // End GoogleMaps

						/* Heading */
						{
							text: 'Heading',
							onclick: function() {
								editor.windowManager.open( {
									title: 'TTBase Shortcodes - Insert Heading',
									body: [

									// Heading Title
									{
										type: 'textbox',
										name: 'headingTitle',
										label: 'Title',
										value: 'Sample heading'
									},

									// Heading Font Size
									{
										type: 'textbox',
										name: 'headingFontSize',
										label: 'Font Size',
										value: ''
									},

									// Heading Color
									{
										type: 'textbox',
										name: 'headingColor',
										label: 'Heading Hex Color',
										value: ''
									},

									// Heading Top Margin
									{
										type: 'textbox',
										name: 'headingMarginTop',
										label: 'Top Margin',
										value: '30'
									},

									// Heading Bottom Margin
									{
										type: 'textbox',
										name: 'headingMarginBottom',
										label: 'Bottom Margin',
										value: '30'
									},

									// Heading Type
									{
										type: 'listbox',
										name: 'headingType',
										label: 'Type',
										values: [
											{text: 'h1', value: 'h1'},
											{text: 'h2', value: 'h2'},
											{text: 'h3', value: 'h3'},
											{text: 'h4', value: 'h4'},
											{text: 'h5', value: 'h5'},
											{text: 'span', value: 'span'},
											{text: 'div', value: 'div'}
										]
									},

									// Heading Style
									{
										type: 'listbox',
										name: 'headingStyle',
										label: 'Style',
										values: [
											{text: 'None', value: ''},
											{text: 'Underline', value: 'single-line'}
										]
									},

									// Heading Text Align
									{
										type: 'listbox',
										name: 'headingTextAlign',
										label: 'Text Align',
										values: [
											{text: 'Left', value: 'left'},
											{text: 'Center', value: 'center'},
											{text: 'Right', value: 'right'}
										]
									},
                                    // Heading Icon Font
                                    {
                                        type: 'listbox',
                                        name: 'headingIconFont',
                                        label: 'Icon Font',
                                        values: [
                                            {text: 'Streamline', value: 'streamline'},
                                            {text: 'Icons Mind', value: 'iconsmind'},
                                            {text: 'Font Awesome', value: 'fontawesome'}
                                        ]
                                    },
                                    // Heading Left Icon
									{
										type: 'textbox',
										name: 'headingLeftIconSL',
										label: 'Left Icon (Streamline Class Name)',
										value: ''
									},

									// Heading Right Icon
									{
										type: 'textbox',
										name: 'headingRightIconSL',
										label: 'Right Icon (Streamline Class Name)',
										value: ''
									},
									// Heading Left Icon
									{
										type: 'textbox',
										name: 'headingLeftIconIM',
										label: 'Left Icon (Icons Mind Class Name)',
										value: ''
									},

									// Heading Right Icon
									{
										type: 'textbox',
										name: 'headingRightIconIM',
										label: 'Right Icon (Icons Mind Class Name)',
										value: ''
									},
									// Heading Left Icon
									{
										type: 'textbox',
										name: 'headingLeftIconFA',
										label: 'Left Icon (FontAwesome Class Name)',
										value: ''
									},

									// Heading Right Icon
									{
										type: 'textbox',
										name: 'headingRightIconFA',
										label: 'Right Icon (FontAwesome Class Name)',
										value: ''
									}],
									onsubmit: function( e ) {
										editor.insertContent('[ttbase_heading style="' + e.data.headingStyle + '" title="' + e.data.headingTitle + '" type="' + e.data.headingType + '" font_size="' + e.data.headingFontSize + '" text_align="' + e.data.headingTextAlign + '" margin_top="' + e.data.headingMarginTop + '" margin_bottom="' + e.data.headingMarginBottom + '" color="' + e.data.headingColor + '" icon_font="' + e.data.headingIconFont + '" icon_left_sl="' + e.data.headingLeftIconSL + '" icon_right_sl="' + e.data.headingRightIconSL + '"icon_left_im="' + e.data.headingLeftIconIM + '" icon_right_im="' + e.data.headingRightIconIM + '" icon_left_fa="' + e.data.headingLeftIconFA + '" icon_right_fa="' + e.data.headingRightIconFA + '"]' );
									}
								});
							}
						}, // End heading

						/* Highlights */
						{
							text: 'Highlight',
							onclick: function() {
								editor.windowManager.open( {
									title: 'TTBase Shortcodes - Insert Highlight',
									body: [

									// Highlight Color
									{
										type: 'listbox',
										name: 'highlightColor',
										label: 'Size',
										values: [
											{text: 'Blue', value: 'blue'},
											{text: 'Green', value: 'green'},
											{text: 'Yellow', value: 'yellow'},
											{text: 'Red', value: 'red'},
											{text: 'Gray', value: 'gray'}
										]
									},

									// Highlight Content
									{
										type: 'textbox', 
										name: 'highlightContent', 
										label: 'Highlighted Text',
										value: 'hey check me out'
									}],
									onsubmit: function( e ) {
										editor.insertContent('[ttbase_highlight color="' + e.data.highlightColor + '"]' + e.data.highlightContent + '[/ttbase_highlight]');
									}
								});
							}
						}, // End highlights
						
							/* Icon */
						{
							text: 'Icon',
							onclick: function() {
								editor.windowManager.open( {
									title: 'TTBase Shortcodes - Insert Icon',
									body: [

									// Icon Icon Font
                                    {
                                        type: 'listbox',
                                        name: 'iconIconFont',
                                        label: 'Icon Icon Font',
                                        values: [
                                            {text: 'Streamline', value: 'streamline'},
                                            {text: 'Icons Mind', value: 'iconsmind'},
                                            {text: 'Font Awesome', value: 'fontawesome'}
                                        ]
                                    },
                                    // Icon Font Awesome Icon
                                    {
                                        type: 'textbox',
                                        name: 'iconIconFontAwesome',
                                        label: 'Icon (Font Awesome value without fa-)',
                                        value: 'none'
                                    },
                                    // Icon Icons Mind Icon
                                    {
                                        type: 'textbox',
                                        name: 'iconIconIM',
                                        label: 'Icon (Icons Mind value without im- or icon-)',
                                        value: 'none'
                                    },
                                    // Icon Streamline Icon
                                    {
                                        type: 'textbox',
                                        name: 'iconIconStreamline',
                                        label: 'Icon (Streamline value without sl-)',
                                        value: 'none'
                                    },
                                    // Icon Background Style
                                    {
                                        type: 'listbox',
                                        name: 'iconIconStyle',
                                        label: 'Icon Background Style',
                                        values: [
                                            {text: 'No Background', value: ''},
                                            {text: 'Circle', value: 'circle'},
                                            {text: 'Square', value: 'square'}
                                        ]
                                    },
                                    // Icon Size
                                    {
                                        type: 'listbox',
                                        name: 'iconIconSize',
                                        label: 'Icon Size',
                                        values: [
                                            {text: 'Extra Large', value: 'xlarge'},
                                            {text: 'Large', value: 'large'},
                                            {text: 'Normal', value: 'normal'},
                                            {text: 'Small', value: 'small'},
                                            {text: 'Tiny', value: 'tiny'},
                                        ]
                                    },
                                     // Icon Fade In
                                    {
                                        type: 'listbox',
                                        name: 'iconIconFadeIn',
                                        label: 'Icon Fade In?',
                                        values: [
                                            {text: 'No', value: 'false'},
                                            {text: 'Yes', value: 'true'}
                                        ]
                                    },
                                    // Icon Float
                                    {
                                        type: 'listbox',
                                        name: 'iconIconFloat',
                                        label: 'Icon Float',
                                        values: [
                                            {text: 'Center', value: 'center'},
                                            {text: 'Left', value: 'left'},
                                            {text: 'Right', value: 'right'}
                                        ]
                                    },
                                    // Icon Color
									{
										type: 'textbox',
										name: 'iconIconColor',
										label: 'Icon Hex Color',
										value: ''
									},
									// Icon Background Color
									{
										type: 'textbox',
										name: 'iconIconBackgroundColor',
										label: 'Icon Background Hex Color',
										value: ''
									},
									// Icon Border Radius
									{
										type: 'textbox',
										name: 'iconIconBorderRadius',
										label: 'Icon Border Radius',
										value: ''
									},
								    // Icon Url
                                    {
                                        type: 'textbox',
                                        name: 'iconUrl',
                                        label: 'Url',
                                        value: ''
                                    },
                                    // Icon Url Title
                                    {
                                        type: 'textbox',
                                        name: 'iconUrlTitle',
                                        label: 'Url Title',
                                        value: ''
                                    }],
									onsubmit: function( e ) {
										editor.insertContent('[ttbase_icon icon_font="' + e.data.iconIconFont + '" icon_sl="' + e.data.iconIconStreamline + '"icon_im="' + e.data.iconIconIM + '" icon_fa="' + e.data.iconIconFontAwesome + '" style="' + e.data.iconIconStyle + '" size="' + e.data.iconIconSize + '" fade_in="' + e.data.iconIconFadeIn + '" color="' + e.data.iconIconColor + '" border_radius="' + e.data.iconIconBorderRadius + '" background="' + e.data.iconIconBackgroundColor + '" url="' + e.data.iconUrl + '" url_title="' + e.data.iconUrltitle + '"]');
									}
								});
							}
						}, // End Icon

                        /* Icon Box*/
                        {
                            text: 'Icon Box',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'TTBase Shortcodes - Icon Box',
                                    body: [

                                        // Icon Box ID
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxUniqueId',
                                            label: 'Unique ID (Optional)',
                                            value: ''
                                        },
                                        // Icon Box Background Color
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxBackgroundColor',
                                            label: 'Background Color (HEX)',
                                            value: ''
                                        },

                                        // Icon Box Style
                                        {
                                            type: 'listbox',
                                            name: 'iconBoxStyle',
                                            label: 'Icon Box Style',
                                            values: [
                                                {text: 'Left Icon', value: 'one'},
                                                {text: 'Right Icon', value: 'seven'},
                                                {text: 'Top Icon', value: 'two'},
                                                {text: 'Top Icon Style 2 (legacy)', value: 'three'},
                                                {text: 'Outlined & Top Icon', value: 'four'},
                                                {text: 'Boxed & Top Icon', value: 'five'},
                                                {text: 'Boxed & Top Icon Style 2', value: 'six'}
                                            ]
                                        },
                                        // Icon Box Image Alternative
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxImageAlternative',
                                            label: 'Icon Image Alternative',
                                            value: 'IMAGE_URL'
                                        },
                                        // Icon Box Image Alternative Width
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxImageAlternativeWidth',
                                            label: 'Icon Image Alternative Width',
                                            value: ''
                                        },
                                        // Icon Box Icon Font
                                        {
                                            type: 'listbox',
                                            name: 'iconBoxIconFont',
                                            label: 'Icon Box Icon Font',
                                            values: [
                                                {text: 'Streamline', value: 'streamline'},
                                                {text: 'Icons Mind', value: 'iconsmind'},
                                                {text: 'Font Awesome', value: 'fontawesome'}
                                            ]
                                        },
                                        // Icon Box Font Awesome Icon
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconFontAwesome',
                                            label: 'Icon (Font Awesome value without fa-)',
                                            value: 'bell'
                                        },
                                        // Icon Box Icons Mind Icon
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconIM',
                                            label: 'Icon (Icons Mind value without im- or icon-)',
                                            value: 'bell'
                                        },
                                        // Icon Box Streamline Icon
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconStreamline',
                                            label: 'Icon (Streamline value without sl-)',
                                            value: 'flash'
                                        },
                                        // Icon Box Icon Alternative Class
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconAlternativeClass',
                                            label: 'Icon Font Alternative Classes',
                                            value: ''
                                        },
                                        // Icon Box Icon Color
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconColor',
                                            label: 'Icon Color (HEX)',
                                            value: ''
                                        },
                                        // Icon Box Icon Background Color
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconBackgroundColor',
                                            label: 'Icon Background Color (HEX)',
                                            value: ''
                                        },
                                        // Icon Border Radius
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconBorderRadius',
                                            label: 'Icon Border Radius',
                                            value: ''
                                        },
                                        // Icon Size
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconSize',
                                            label: 'Icon Size in px',
                                            value: ''
                                        },
                                        // Fixed Icon Width
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconWidth',
                                            label: 'Fixed Icon Width',
                                            value: ''
                                        },
                                        // Fixed Icon Height
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconHeight',
                                            label: 'Fixed Icon Height',
                                            value: ''
                                        },
                                        // Icon Box CSS Animation
                                        {
                                            type: 'listbox',
                                            name: 'iconBoxCssAnimation',
                                            label: 'Icon Box CSS Animation',
                                            values: [
                                                {text: 'No', value: ''},
                                                {text: 'Top to bottom', value: 'top-to-bottom'},
                                                {text: 'Bottom to top', value: 'bottom-to-top'},
                                                {text: 'Left to right', value: 'left-to-right'},
                                                {text: 'Right to left', value: 'right-to-left'},
                                                {text: 'Appear from center', value: 'appear'}
                                            ]
                                        },
                                        // Icon Box Alignment
                                        {
                                            type: 'listbox',
                                            name: 'iconBoxAlignment',
                                            label: 'Icon Box Alignment (only for Top Icon Style)',
                                            values: [
                                                {text: 'Default', value: ''},
                                                {text: 'Center', value: 'center'},
                                                {text: 'Left', value: 'left'},
                                                {text: 'Right', value: 'right'}
                                            ]
                                        },
                                        // Icon Bottom Margin
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxIconBottomMargin',
                                            label: 'Icon Bottom Margin',
                                            value: ''
                                        },
                                        // Icon Container Right Padding
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxContainerRightPadding',
                                            label: 'Container Right Padding',
                                            value: ''
                                        },
                                        // Icon Container Left Padding
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxContainerLeftPadding',
                                            label: 'Container Left Padding',
                                            value: ''
                                        },
                                        // Icon Container Background Color
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxBackgroundColor',
                                            label: 'Container Background Color (HEX)',
                                            value: ''
                                        },
                                        // Icon Container Background Image
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxBackgroundImage',
                                            label: 'Container Background Image',
                                            value: 'IMAGE_URL'
                                        },
                                        // Icon Container Background Image Style
                                        {
                                            type: 'listbox',
                                            name: 'iconBoxBackgroundImageStyle',
                                            label: 'Background Image Style',
                                            values: [
                                                {text: 'Default', value: ''},
                                                {text: 'Stretched', value: 'stretch'},
                                                {text: 'Fixed', value: 'fixed'},
                                                {text: 'Repeat', value: 'repeat'}
                                            ]
                                        },
                                        // Icon Box Border Color
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxBorderColor',
                                            label: 'Border Color (HEX)',
                                            value: ''
                                        },
                                        // Icon Box Padding
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxPadding',
                                            label: 'Padding',
                                            value: ''
                                        },
                                        // Icon Box Border Radius
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxBorderRadius',
                                            label: 'Border Radius',
                                            value: ''
                                        },
                                        // Icon Box Heading
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxHeading',
                                            label: 'Heading',
                                            value: 'Sample Heading'
                                        },
                                        // Icon Box Heading Type
                                        {
                                            type: 'listbox',
                                            name: 'iconBoxHeadingType',
                                            label: 'Heading Type',
                                            values: [
                                                {text: 'h2', value: 'h2'},
                                                {text: 'h3', value: 'h3'},
                                                {text: 'h4', value: 'h4'},
                                                {text: 'h5', value: 'h5'},
                                                {text: 'div', value: 'div'},
                                                {text: 'span', value: 'span'}
                                            ]
                                        },
                                        // Icon Box Heading Font Color
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxHeadingFontColor',
                                            label: 'Heading Font Color (HEX)',
                                            value: ''
                                        },
                                        // Icon Box Heading Font Size
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxHeadingFontSize',
                                            label: 'Heading Font Size',
                                            value: ''
                                        },
                                        // Icon Box Heading Font Weight
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxHeadingFontWeight',
                                            label: 'Heading Font Weight',
                                            value: ''
                                        },
                                        // Icon Box Heading Letter Spacing
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxHeadingLetterSpacing',
                                            label: 'Heading Letter Spacing',
                                            value: ''
                                        },
                                        // Icon Box Heading Text Transform
                                        {
                                            type: 'listbox',
                                            name: 'iconBoxHeadingTextTransform',
                                            label: 'Heading Text Transform',
                                            values: [
                                                {text: 'Default', value: ''},
                                                {text: 'None', value: 'none'},
                                                {text: 'Capitalize', value: 'capitalize'},
                                                {text: 'Uppercase', value: 'uppercase'},
                                                {text: 'Lowercase', value: 'lowercase'}
                                            ]
                                        },
                                        // Icon Box Heading Bottom Margin
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxHeadingBottomMargin',
                                            label: 'Heading Bottom Margin',
                                            value: ''
                                        },
                                        // Icon Box Content Font Size
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxFontSize',
                                            label: 'Content Font Size',
                                            value: ''
                                        },
                                        // Icon Box Content Font Color
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxFontColor',
                                            label: 'Content Font Color (HEX)',
                                            value: ''
                                        },
                                        // Icon Box Content
                                        {
                                            type: 'textbox',
                                            multiline: true,
                                            minWidth: 300,
                                            minHeight: 100,
                                            name: 'iconBoxContent',
                                            label: 'Content',
                                            value: 'This is a intro text.'
                                        },
                                        // Icon Box Url
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxUrl',
                                            label: 'Url',
                                            value: '#'
                                        },
                                        // Icon Box Url Target
                                        {
                                            type: 'listbox',
                                            name: 'iconBoxUrlTarget',
                                            label: 'URL Target',
                                            values: [
                                                {text: 'Self', value: ''},
                                                {text: 'Blank', value: '_blank'},
                                                {text: 'Local', value: 'local'}
                                            ]
                                        },
                                        // Icon Box Url Rel
                                        {
                                            type: 'listbox',
                                            name: 'iconBoxUrlRel',
                                            label: 'URL Rel',
                                            values: [
                                                {text: 'None', value: ''},
                                                {text: 'Nofollow', value: 'nofollow'}
                                            ]
                                        },
                                        // Bottom Margin
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxBottomMargin',
                                            label: 'Bottom Margin',
                                            value: ''
                                        },
                                        // Extra CSS Class name
                                        {
                                            type: 'textbox',
                                            name: 'iconBoxElClass',
                                            label: 'Extra class name',
                                            value: ''
                                        }
                                         ],
                                    onsubmit: function( e ) {
                                        editor.insertContent('[ttbase_icon_box unique_id="' + e.data.iconBoxUniqueId + '" font_size="' + e.data.iconBoxFontSize + '" background="' + e.data.iconBoxBackgroundColor + '" font_color="' + e.data.iconBoxFontColor + '" border_radius="' + e.data.iconBoxBorderRadius + '" style="' + e.data.iconBoxStyle + '" image="' + e.data.iconBoxImageAlternative + '" image_width="' + e.data.iconBoxImageAlternativeWidth + '" icon_font="' + e.data.iconBoxIconFont + '" icon_sl="' + e.data.iconBoxIconStreamline + '"icon_im="' + e.data.iconBoxIconIM + '" icon_fa="' + e.data.iconBoxIconFontAwesome + '" icon_color="' + e.data.iconBoxIconColor + '" icon_width="' + e.data.iconBoxIconWidth + '" icon_height="' + e.data.iconBoxIconHeight + '" icon_alternative_classes="' + e.data.iconBoxIconAlternativeClass + '" icon_size="' + e.data.iconBoxIconSize + '" icon_background="' + e.data.iconBoxBackgroundColor + '" icon_border_radius="' + e.data.iconBoxBorderRadius + '" icon_bottom_margin="' + e.data.iconBoxBottomMargin + '" heading="' + e.data.iconBoxHeading + '" heading_type="' + e.data.iconBoxHeadingType + '" heading_color="' + e.data.iconBoxHeadingFontColor + '" heading_size="' + e.data.iconBoxHeadingFontSize + '" heading_weight="' + e.data.iconBoxHeadingFontWeight + '" heading_letter_spacing="' + e.data.iconBoxHeadingLetterSpacing + '" heading_transform="' + e.data.iconBoxHeadingTextTransform + '" heading_bottom_margin="' + e.data.iconBoxHeadingBottomMargin + '" container_left_padding="' + e.data.iconBoxContainerLeftPadding + '" container_right_padding="' + e.data.iconBoxContainerRightPadding + '" url="' + e.data.IconBoxUrl + '" url_target="' + e.data.IconBoxUrlTarget + '" url_rel="' + e.data.IconBoxUrlRel + '" css_animation="' + e.data.IconBoxCssAnimation + '" padding="' + e.data.IconBoxPadding + '" margin_bottom="' + e.data.IconBoxMarginBottom + '" el_class="' + e.data.IconBoxElClass + '" alignment="' + e.data.IconBoxAlignment + '" background_image="' + e.data.IconBoxBackgroundImage + '" background_image_style="' + e.data.IconBoxBackgroundImageStyle + '" border_color="' + e.data.IconBoxBorderColor + '"]' + e.data.iconBoxContent + '[/ttbase_icon_box]');
                                    }
                                });
                            }
                        }, // End Icon Box
                        /* Image Box*/
                        {
                            text: 'Image Box',
                            onclick: function() {
                                editor.windowManager.open( {
                                    title: 'TTBase Shortcodes - Image Box',
                                    body: [

                                        // Image Box Image
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxImage',
                                            label: 'Image',
                                            value: 'IMAGE_URL'
                                        },
                                        // Image Box Overlay Color
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxOverlayColor',
                                            label: 'Overlay Color (HEX)',
                                            value: ''
                                        },
                                        // Image Box Url
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxUrl',
                                            label: 'Url',
                                            value: '#'
                                        },
                                        // Image Box Url Target
                                        {
                                            type: 'listbox',
                                            name: 'imageBoxUrlTarget',
                                            label: 'URL Target',
                                            values: [
                                                {text: 'Self', value: ''},
                                                {text: 'Blank', value: '_blank'},
                                                {text: 'Local', value: 'local'}
                                            ]
                                        },
                                        // Image Box Icon Image
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxIconImage',
                                            label: 'Icon Image',
                                            value: 'ICON_IMAGE_URL'
                                        },
                                        // Icon Box Image Width
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxIconImageWidth',
                                            label: 'Icon Image Width',
                                            value: ''
                                        },
                                        // Image Box Icon Font
                                        {
                                            type: 'listbox',
                                            name: 'imageBoxIconFont',
                                            label: 'Image Box Icon Font',
                                            values: [
                                                {text: 'Streamline', value: 'streamline'},
                                                {text: 'Icons Mind', value: 'iconsmind'},
                                                {text: 'Font Awesome', value: 'fontawesome'}
                                            ]
                                        },
                                        // Image Box Font Awesome Icon
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxIconFontAwesome',
                                            label: 'Icon (Font Awesome value without fa-)',
                                            value: 'bell'
                                        },
                                        // Image Box Icons Mind Icon
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxIconIM',
                                            label: 'Icon (Icons Mind value without im- or icon-)',
                                            value: 'bell'
                                        },
                                        // Image Box Streamline Icon
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxIconStreamline',
                                            label: 'Icon (Streamline value without sl-)',
                                            value: 'flash'
                                        },
                                        // Image Box Icon Color
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxIconColor',
                                            label: 'Icon Color (HEX)',
                                            value: ''
                                        },
                                        // IMage Box Heading
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxHeading',
                                            label: 'Heading',
                                            value: 'Sample Heading'
                                        },
                                        // Image Box Heading Type
                                        {
                                            type: 'listbox',
                                            name: 'imageBoxHeadingType',
                                            label: 'Heading Type',
                                            values: [
                                                {text: 'h2', value: 'h2'},
                                                {text: 'h3', value: 'h3'},
                                                {text: 'h4', value: 'h4'},
                                                {text: 'h5', value: 'h5'},
                                                {text: 'div', value: 'div'},
                                                {text: 'span', value: 'span'}
                                            ]
                                        },
                                        // Image Box Heading Font Color
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxHeadingFontColor',
                                            label: 'Heading Font Color (HEX)',
                                            value: ''
                                        },
                                        // Image Box Heading Font Size
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxHeadingFontSize',
                                            label: 'Heading Font Size',
                                            value: ''
                                        },
                                        // Image Box Heading Font Weight
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxHeadingFontWeight',
                                            label: 'Heading Font Weight',
                                            value: ''
                                        },
                                        // Image Box Heading Letter Spacing
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxHeadingLetterSpacing',
                                            label: 'Heading Letter Spacing',
                                            value: ''
                                        },
                                        // Image Box Heading Text Transform
                                        {
                                            type: 'listbox',
                                            name: 'imageBoxHeadingTextTransform',
                                            label: 'Heading Text Transform',
                                            values: [
                                                {text: 'Default', value: ''},
                                                {text: 'None', value: 'none'},
                                                {text: 'Capitalize', value: 'capitalize'},
                                                {text: 'Uppercase', value: 'uppercase'},
                                                {text: 'Lowercase', value: 'lowercase'}
                                            ]
                                        },
                                        // Image Box Heading Bottom Margin
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxHeadingBottomMargin',
                                            label: 'Heading Bottom Margin',
                                            value: ''
                                        },
                                        // IMage Box Subtitle
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxSubtitle',
                                            label: 'Subtitle',
                                            value: 'Sample Subtitle'
                                        },
                                        // Image Box Subtitle Font Color
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxSubtitleFontColor',
                                            label: 'Subtitle Font Color (HEX)',
                                            value: ''
                                        },
                                        // Image Box Subtitle Font Size
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxSubtitleFontSize',
                                            label: 'Subtitle Font Size',
                                            value: ''
                                        },
                                        // Image Box Subtitle Font Weight
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxSubtitleFontWeight',
                                            label: 'Subtitle Font Weight',
                                            value: ''
                                        },
                                        // Image Box Subtitle Letter Spacing
                                        {
                                            type: 'textbox',
                                            name: 'imageBoxSubtitleLetterSpacing',
                                            label: 'Subtitle Letter Spacing',
                                            value: ''
                                        },
                                        // Image Box Subtitle Text Transform
                                        {
                                            type: 'listbox',
                                            name: 'imageBoxSubtitleTextTransform',
                                            label: 'Subtitle Text Transform',
                                            values: [
                                                {text: 'Default', value: ''},
                                                {text: 'None', value: 'none'},
                                                {text: 'Capitalize', value: 'capitalize'},
                                                {text: 'Uppercase', value: 'uppercase'},
                                                {text: 'Lowercase', value: 'lowercase'}
                                            ]
                                        }
                                         ],
                                    onsubmit: function( e ) {
                                        editor.insertContent('[ttbase_imagebox image="' + e.data.imageBoxImage + '" overlay_color="' + e.data.imageBoxOverlayColor + '" icon_image="' + e.data.imageBoxIconImage + '" icon_image_width="' + e.data.imageBoxIconImageWidth + '" icon_font="' + e.data.imageBoxIconFont + '" icon_sl="' + e.data.imageBoxIconStreamline + '"icon_im="' + e.data.imageBoxIconIM + '" icon_fa="' + e.data.imageBoxIconFontAwesome + '" icon_color="' + e.data.imageBoxIconColor + '" heading="' + e.data.imageBoxHeading + '" heading_type="' + e.data.imageBoxHeadingType + '" heading_color="' + e.data.imageBoxHeadingFontColor + '" heading_size="' + e.data.imageBoxHeadingFontSize + '" heading_weight="' + e.data.imageBoxHeadingFontWeight + '" heading_letter_spacing="' + e.data.imageBoxHeadingLetterSpacing + '" heading_transform="' + e.data.imageBoxHeadingTextTransform + '" heading_bottom_margin="' + e.data.imageBoxHeadingBottomMargin + '" subtitle="' + e.data.imageBoxSubtitle + '" subtitle_color="' + e.data.imageBoxSubtitleFontColor + '" subtitle_size="' + e.data.imageBoxSubtitleFontSize + '" subtitle_weight="' + e.data.imageBoxSubtitleFontWeight + '" subtitle_letter_spacing="' + e.data.imageBoxSubtitleLetterSpacing + '" subtitle_transform="' + e.data.imageBoxSubtitleTextTransform + '"  url="' + e.data.ImageBoxUrl + '" url_target="' + e.data.ImageBoxUrlTarget + '"]');
                                    }
                                });
                            }
                        }, // End Image Box

						/* Intro Text */
						{
							text: 'Intro Text',
							onclick: function() {
								editor.windowManager.open( {
									title: 'TTBase Shortcodes - Insert Intro Text',
									
									body: [

									// Teaser Color
									{
										type: 'textbox',
										name: 'teaserColor',
										label: 'Text Color',
										value: '#707573'
									},
									// Text Align
									{
										type: 'listbox',
										name: 'teaserTextAlign',
										label: 'Text Align',
										values: [
											{text: 'Left', value: 'left'},
											{text: 'Center', value: 'center'},
											{text: 'Right', value: 'right'}
										]
									},

									// Teaser Content
									{
										type: 'textbox',
										multiline: true,
										minWidth: 300,
										minHeight: 100,
										name: 'teaserContent', 
										label: 'Text',
										value: 'This is a intro text.'
									}],
									onsubmit: function( e ) {
										editor.insertContent('[ttbase_intro_text color="' + e.data.teaserColor + '" text_align="' + e.data.teaserTextAlign + '"]' + e.data.teaserContent + '[/ttbase_intro_text]');
									}
								});
							}
						}, // End Intro Text
                        
            			/* Progressbars */
						{
							text: 'Progressbar',
							onclick: function() {
								editor.windowManager.open( {
									title: 'TTBase Shortcodes - Insert Progressbar',
									body: [

									// Skillbar Title
									{
										type: 'textbox',
										name: 'progressTitle',
										label: 'Progress',
										value: ''
									},

									// Skillbar Percentage
									{
										type: 'textbox',
										name: 'progressPercentage',
										label: 'Percentage',
										value: '85'
									},

									// Skillbar Color
									{
										type: 'textbox',
										name: 'progressColor',
										label: 'Color Hex',
										value: '#3cb087'
									},

									// Skillbar Show Percent
									{
										type: 'listbox',
										name: 'progressShowPercent',
										label: 'Show Percent',
										values: [
											{text: 'Yes', value: 'true'},
											{text: 'No', value: 'false'}
										]
									}

									],
									onsubmit: function( e ) {
										editor.insertContent('[ttbase_progressbar title="' + e.data.progressTitle + '" percentage="' + e.data.progressPercentage + '" color="' + e.data.progressColor + '" show_percent="' + e.data.progressShowPercent + '"]');
									}
								});
							}
						}, // End Skillbar
						
							/* Spacer */
						{
							text: 'Empty Space',
							onclick: function() {
								editor.windowManager.open( {
									title: 'TTBase Shortcodes - Insert Empty Space',
									body: [

									// Spacer Height
									{
										type: 'textbox', 
										name: 'spacerHeight', 
										label: 'Height',
										value: '10'
									}],
									onsubmit: function( e ) {
										editor.insertContent('[ttbase_spacer height="' + e.data.spacerHeight + '"]');
									}
								});
							}
						}, // End highlights
						
						/* Pricing */
						{
							text: 'Pricing',
							onclick: function() {
								editor.windowManager.open( {
									title: 'TTBase Shortcodes - Insert Pricing',
									autoScroll: true,
									height: 450,
									width: 780,
									body: [

									// New Table?
									{
										type: 'listbox',
										name: 'newPricingTable',
										label: 'New Table?',
										values: [
											{text: 'Yes', value: 'yes'},
											{text: 'No', value: 'no'}
										]
									},

									// Pricing Featured
									{
										type: 'listbox',
										name: 'pricingFeatured',
										label: 'Featured?',
										values: [
											{text: 'No', value: 'no'},
											{text: 'Yes', value: 'yes'}
										]
									},

									// Pricing Plan
									{
										type: 'textbox',
										name: 'pricingPlan',
										label: 'Plan',
										value: 'Basic'
									},

									// Pricing Cost
									{
										type: 'textbox',
										name: 'pricingCost',
										label: 'Cost',
										value: '$20'
									},

									// Pricing Per
									{
										type: 'textbox',
										name: 'pricingPer',
										label: 'Per (optional)',
										value: 'per month'
									},

									// Pricing Button Text
									{
										type: 'textbox',
										name: 'pricingButtonText',
										label: 'Button: Text',
										value: 'Purchase'
									},

									// Pricing Button URL
									{
										type: 'textbox',
										name: 'pricingButtonUrl',
										label: 'Button: URL',
										value: '#'
									},

									// Pricing Button Color
									{
										type: 'listbox',
										name: 'pricingButtonStyle',
										label: 'Button: Style',
										values: [
											{text: 'Style 1', value: 'style-1'},
											{text: 'Style 2', value: 'style-2'}
										]
									},

									// Pricing Button Size
									{
										type: 'listbox',
										name: 'pricingButtonSize',
										label: 'Button: Size',
										values: [
											{text: 'Default', value: ''},
											{text: 'Small', value: 'small'},
											{text: 'Medium', value: 'medium'},
											{text: 'Large', value: 'large'}
										]
									},

									// Pricing Button Link Target
									{
										type: 'listbox',
										name: 'pricingButtonLinkTarget',
										label: 'Button: Link Target',
										values: [
											{text: 'Self', value: 'self'},
											{text: 'Blank', value: 'blank'}
										]
									},

									// Pricing Button Rel
									{
										type: 'listbox',
										name: 'pricingButtonRel',
										label: 'Button: Rel',
										values: [
											{text: 'None', value: ''},
											{text: 'Nofollow', value: 'nofollow'}
										]
									},

									// Pricing Button Left Icon
									{
										type: 'textbox',
										name: 'pricingButtonLeftIcon',
										label: 'Button: Left Icon (FontAwesome Class Name)',
										value: ''
									},

									// Pricing Button Right Icon
									{
										type: 'textbox',
										name: 'pricingButtonRightIcon',
										label: 'Button: Right Icon (FontAwesome Class Name)',
										value: ''
									},

									// Pricing Features
									{
										type: 'textbox',
										name: 'pricingFeatures',
										label: 'Features (ul list is best)',
										value: '<ul><li>30GB Storage</li><li>512MB Ram</li><li>10 databases</li><li>1,000 Emails</li><li>25GB Bandwidth</li></ul>',
										multiline: true,
										minWidth: 400,
										minHeight: 200
									}

									],
									onsubmit: function( e ) {
										if ( e.data.newPricingTable === 'yes' ){
											var $openPricingTable = '[ttbase_pricing_table]';
											var $closePricingTable = '[/ttbase_pricing_table]';
										} else {
											var $openPricingTable = '';
											var $closePricingTable = '';
										}
										editor.insertContent( '' + $openPricingTable + '[ttbase_pricing featured="' + e.data.pricingFeatured + '" plan="' + e.data.pricingPlan + '" cost="' + e.data.pricingCost + '" per="' + e.data.pricingPer + '" button_text="' + e.data.pricingButtonText + '" button_url="' + e.data.pricingButtonUrl + '" button_style="' + e.data.pricingButtonStyle + '" button_size="' + e.data.pricingButtonSize + '" button_target="' + e.data.pricingButtonLinkTarget + '" button_rel="' + e.data.pricingButtonRel + '" button_icon_left="' + e.data.pricingButtonLeftIcon + '" button_icon_right="' + e.data.pricingButtonRightIcon + '"]' + e.data.pricingFeatures + '[/ttbase_pricing]' + $closePricingTable + '');
									}
								});
							}
						}, // End pricing

					]
				}, // End Elements Section
				
				/** Posts Start **/
				{
				text: 'Posts',
				menu: [
					
                /* Testimonial Carousel */
                    {
                        text: 'Testimonial Carousel',
                        onclick: function() {
                            editor.windowManager.open( {
                                title: 'TTBase Shortcodes - Insert Testimonial Carousel',
                                body: [
                                    // Parent Category
                                {
                                    type: 'textbox',
                                    name: 'testimonialCategories',
                                    label: 'Testimonial Carousel: Categories',
                                    values: 'all'
                                },
                                // Testimonial Max Items
                                {
                                    type: 'textbox',
                                    name: 'testimonialMaxItems',
                                    label: 'Testimonial Carousel: Max Items',
                                    value: ''
                                },
                                // Testimonial Carousel Image Crop
                                {
                                    type: 'listbox',
                                    name: 'testimonialImageCrop',
                                    label: 'Testimonial Carousel: Image Crop',
                                    values: [
                                        {text: 'Yes', value: 'true'},
                                        {text: 'No', value: 'false'}
                                    ]
                                },
                                // Testimonial Image Width
                                {
                                    type: 'textbox',
                                    name: 'testimonialImageWidth',
                                    label: 'Testimonial Carousel: Image Width',
                                    value: ''
                                },
                                // Testimonial Image Height
                                {
                                    type: 'textbox',
                                    name: 'testimonialImageHeight',
                                    label: 'Testimonial Carousel: Image Height',
                                    value: ''
                                },
                                ],
                                onsubmit: function( e ) {
                                    editor.insertContent('[ttbase_testimonial_carousel categories="' + e.data.testimonialCategories + '" img_crop="' + e.data.testimonialImageCrop + '" img_width="' + e.data.testimonialImageWidth + '" img_height="' + e.data.testimonialImageHeight + '" posts="' + e.data.testimonialMaxItems + '"]');
                                }
                            });
                        }
                    }, // End Testimonial Carousel
                    /* Testimonial Grid */
                    {
                        text: 'Testimonial Grid',
                        onclick: function() {
                            editor.windowManager.open( {
                                title: 'TTBase Shortcodes - Insert Testimonial Grid',
                                body: [
                                    // Parent Category
                                {
                                    type: 'textbox',
                                    name: 'testimonialGridCategories',
                                    label: 'Testimonial Grid: Categories',
                                    values: 'all'
                                },
                                // Testimonial Max Items
                                {
                                    type: 'textbox',
                                    name: 'testimonialGridPosts',
                                    label: 'Testimonial Grid: Number of Testimonials',
                                    value: ''
                                },
                                // Testimonial Grid Show Filter
                                {
                                    type: 'listbox',
                                    name: 'testimonialGridShowFilter',
                                    label: 'Testimonial Grid: Show Categories Filter?',
                                    values: [
                                        {text: 'No', value: 'no'},
                                        {text: 'Yes', value: 'yes'}
                                    ]
                                },
                                // Testimonial Grid Image Crop
                                {
                                    type: 'listbox',
                                    name: 'testimonialGridImageCrop',
                                    label: 'Testimonial Grid: Image Crop',
                                    values: [
                                        {text: 'Yes', value: 'true'},
                                        {text: 'No', value: 'false'}
                                    ]
                                },
                                // Testimonial Image Width
                                {
                                    type: 'textbox',
                                    name: 'testimonialGridImageWidth',
                                    label: 'Testimonial Grid: Image Width',
                                    value: ''
                                },
                                // Testimonial Image Height
                                {
                                    type: 'textbox',
                                    name: 'testimonialGridImageHeight',
                                    label: 'Testimonial Grid: Image Height',
                                    value: ''
                                },
                                // Background Color
                                {
                                    type: 'textbox',
                                    name: 'testimonialGridBackgroundColor',
                                    label: 'Testimonial Grid: Background Color Hex',
                                    value: ''
                                },
                                // Border Color
                                {
                                    type: 'textbox',
                                    name: 'testimonialGridBorderColor',
                                    label: 'Testimonial Grid: Border Color Hex',
                                    value: ''
                                },
                                // Text Color
                                {
                                    type: 'textbox',
                                    name: 'testimonialGridTextColor',
                                    label: 'Testimonial Grid: Text Color Hex',
                                    value: ''
                                },
                                // Author Name Color
                                {
                                    type: 'textbox',
                                    name: 'testimonialGridAuthorColor',
                                    label: 'Testimonial Grid: Author Name Color Hex',
                                    value: ''
                                },
                                // Company Name Color
                                {
                                    type: 'textbox',
                                    name: 'testimonialGridCompanyColor',
                                    label: 'Testimonial Grid: Company Name Color Hex',
                                    value: ''
                                },
                                ],
                                onsubmit: function( e ) {
                                    editor.insertContent('[ttbase_testimonial_grid categories="' + e.data.testimonialGridCategories + '" posts="' + e.data.testimonialGridPosts + '" showfilter="' + e.data.testimonialGridShowFilter + '" img_crop="' + e.data.testimonialGridImageCrop + '" img_width="' + e.data.testimonialGridImageWidth + '" img_height="' + e.data.testimonialGridImageHeight + '" background_color="' + e.data.testimonialGridBackgroundColor + '" border_color="' + e.data.testimonialGridBorderColor + '" text_color="' + e.data.testimonialGridTextColor + '" author_color="' + e.data.testimonialGridAuthorColor + '" company_color="' + e.data.testimonialGridCompanyColor + '"]');
                                }
                            });
                        }
                    }, // End Testimonial Grid
                    /* Team Grid */
                    {
                        text: 'Team Grid',
                        onclick: function() {
                            editor.windowManager.open( {
                                title: 'TTBase Shortcodes - Insert Team Grid',
                                body: [
                                	// Team Grid Columns
								{
									type: 'listbox',
									name: 'teamGridColumns',
									label: 'Columns',
									values: [
										{text: '1', value: '1'},
										{text: '2', value: '2'},
										{text: '3', value: '3'},
										{text: '4', value: '4'},
										{text: '5', value: '5'},
										{text: '6', value: '6'}
									]
								},
                                // Team Grid Max Items
                                {
                                    type: 'textbox',
                                    name: 'teamGridPosts',
                                    label: 'Team Grid: Number of Team Member',
                                    value: ''
                                },
                                    // Parent Category
                                {
                                    type: 'textbox',
                                    name: 'teamGridCategories',
                                    label: 'Team Grid: Categories',
                                    values: 'all'
                                },
                                
                                // Team Grid Show Filter
                                {
                                    type: 'listbox',
                                    name: 'teamGridShowFilter',
                                    label: 'Team Grid: Show Categories Filter?',
                                    values: [
                                        {text: 'No', value: 'no'},
                                        {text: 'Yes', value: 'yes'}
                                    ]
                                },
                                // Team Grid Pagination
								{
									type: 'listbox',
									name: 'teamGridPagination',
									label: 'Paginate?',
									values: [
										{text: 'No', value: 'false'},
										{text: 'Yes', value: 'true'}
									]
								},
								// Team Grid Order
								{
									type: 'listbox',
									name: 'teamGridOrder',
									label: 'Order',
									values: [
										{text: 'Descending', value: 'DESC'},
										{text: 'Ascending', value: 'ASC'}
									]
								},

								// Team Grid Order by
								{
									type: 'listbox',
									name: 'teamGridOrderBy',
									label: 'Order By',
									values: [
										{text: 'Date', value: 'date'},
										{text: 'Name', value: 'name'},
										{text: 'Random', value: 'random'},
									]
								},
                                // Team Grid Image Crop
                                {
                                    type: 'listbox',
                                    name: 'teamGridImageCrop',
                                    label: 'Team Grid: Image Crop',
                                    values: [
                                        {text: 'Yes', value: 'true'},
                                        {text: 'No', value: 'false'}
                                    ]
                                },
                                // Team Image Width
                                {
                                    type: 'textbox',
                                    name: 'teamGridImageWidth',
                                    label: 'Team Grid: Image Width',
                                    value: ''
                                },
                                // Team Image Height
                                {
                                    type: 'textbox',
                                    name: 'teamGridImageHeight',
                                    label: 'Team Grid: Image Height',
                                    value: ''
                                },
                                	// Team Grid Excerpt
								{
									type: 'listbox',
									name: 'teamGridExcerpt',
									label: 'Display Excerpt?',
									values: [
										{text: 'Yes', value: 'true'},
										{text: 'No', value: 'false'}
									]
								},

								// Team Grid Excerpt
								{
									type: 'textbox',
									name: 'teamGridExcerptLength',
									label: 'Excerpt Length',
									value: '30'
								},

								// Team Grid Read More Link
								{
									type: 'listbox',
									name: 'teamGridReadMore',
									label: 'Read More Link',
									values: [
										{text: 'Yes', value: 'true'},
										{text: 'No', value: 'false'}
									]
								},
								// Team Grid Phone & Mail
								{
									type: 'listbox',
									name: 'teamGridShowPhoneMail',
									label: 'Show Phone and Mail?',
									values: [
										{text: 'No', value: 'false'},
										{text: 'Yes', value: 'true'}
										
									]
								},
								// Team Grid Social Media Icons
								{
									type: 'listbox',
									name: 'teamGridShowSocialIcons',
									label: 'Show Social Media Icons?',
									values: [
										{text: 'Yes', value: 'true'},
										{text: 'No', value: 'false'}
									]
								},
                                // Background Color
                                {
                                    type: 'textbox',
                                    name: 'teamGridBackgroundColor',
                                    label: 'Team Grid: Background Color Hex',
                                    value: ''
                                },
                                // Border Color
                                {
                                    type: 'textbox',
                                    name: 'teamGridBorderColor',
                                    label: 'Team Grid: Border Color Hex',
                                    value: ''
                                }
                                ],
                                onsubmit: function( e ) {
                                    editor.insertContent('[ttbase_team_grid columns="' + e.data.teamGridColumns + '" members="' + e.data.teamGridPosts + '" pagination="' + e.data.teamGridPagination + '" categories="' + e.data.teamGridCategories + '" order="' + e.data.teamGridOrder + '" orderby="' + e.data.teamGridOrderBy + '" showfilter="' + e.data.testimonialGridShowFilter + '" img_crop="' + e.data.teamGridImageCrop + '" img_width="' + e.data.teamGridImageWidth + '" img_height="' + e.data.teamGridImageHeight + '" excerpt="' + e.data.teamGridExcerpt + '" excerpt_length="' + e.data.teamGridExcerptLength + '" read_more="' + e.data.teamGridReadMore + '" show_mail_phone="' + e.data.teamGridShowPhoneMail + '" show_social="' + e.data.teamGridShowSocialIcons + '" background="' + e.data.teamGridBackgroundColor + '" border="' + e.data.teamGridBorderColor + '"]');
                                }
                            });
                        }
                    }, // End Team Grid
                    /* Service Grid */
                    {
                        text: 'Service Grid',
                        onclick: function() {
                            editor.windowManager.open( {
                                title: 'TTBase Shortcodes - Insert Service Grid',
                                body: [
                                // Service Grid Style
                                {
                                    type: 'listbox',
                                    name: 'serviceGridStyle',
                                    label: 'Service Grid: Style',
                                    values: [
                                        {text: 'Plain', value: 'plain'},
                                        {text: 'Outlined', value: 'outlined'}
                                    ]
                                },
                                	// Service Grid Columns
								{
									type: 'listbox',
									name: 'serviceGridColumns',
									label: 'Columns',
									values: [
										{text: '1', value: '1'},
										{text: '2', value: '2'},
										{text: '3', value: '3'},
										{text: '4', value: '4'},
										{text: '5', value: '5'},
										{text: '6', value: '6'}
									]
								},
                                // Service Grid Max Items
                                {
                                    type: 'textbox',
                                    name: 'servcieGridPosts',
                                    label: 'Service Grid: Number of Services',
                                    value: ''
                                },
                                    // Parent Category
                                {
                                    type: 'textbox',
                                    name: 'serviceGridCategories',
                                    label: 'Service Grid: Categories',
                                    values: 'all'
                                },
                                
                                // Service Grid Show Filter
                                {
                                    type: 'listbox',
                                    name: 'serviceGridShowFilter',
                                    label: 'Service Grid: Show Categories Filter?',
                                    values: [
                                        {text: 'No', value: 'no'},
                                        {text: 'Yes', value: 'yes'}
                                    ]
                                },
                                // Service Grid Pagination
								{
									type: 'listbox',
									name: 'serviceGridPagination',
									label: 'Paginate?',
									values: [
										{text: 'No', value: 'false'},
										{text: 'Yes', value: 'true'}
									]
								},
								// Service Grid Order
								{
									type: 'listbox',
									name: 'serviceGridOrder',
									label: 'Order',
									values: [
										{text: 'Descending', value: 'DESC'},
										{text: 'Ascending', value: 'ASC'}
									]
								},

								// Service Grid Order by
								{
									type: 'listbox',
									name: 'serviceGridOrderBy',
									label: 'Order By',
									values: [
										{text: 'Date', value: 'date'},
										{text: 'Name', value: 'name'},
										{text: 'Random', value: 'random'},
									]
								},
                                // Service Grid Image Crop
                                {
                                    type: 'listbox',
                                    name: 'serviceGridImageCrop',
                                    label: 'Service Grid: Image Crop',
                                    values: [
                                        {text: 'Yes', value: 'true'},
                                        {text: 'No', value: 'false'}
                                    ]
                                },
                                // Service Image Width
                                {
                                    type: 'textbox',
                                    name: 'serviceGridImageWidth',
                                    label: 'Service Grid: Image Width',
                                    value: ''
                                },
                                // Service Image Height
                                {
                                    type: 'textbox',
                                    name: 'serviceGridImageHeight',
                                    label: 'Service Grid: Image Height',
                                    value: ''
                                },
                                // Service Image Padding
                                {
                                    type: 'textbox',
                                    name: 'serviceGridImagePadding',
                                    label: 'Service Grid: Image Padding',
                                    value: ''
                                },
                                	// Service Grid Excerpt
								{
									type: 'listbox',
									name: 'serviceGridExcerpt',
									label: 'Display Excerpt?',
									values: [
										{text: 'Yes', value: 'true'},
										{text: 'No', value: 'false'}
									]
								},

								// Service Grid Excerpt
								{
									type: 'textbox',
									name: 'serviceGridExcerptLength',
									label: 'Excerpt Length',
									value: '30'
								},

								// Service Grid Read More Link
								{
									type: 'listbox',
									name: 'serviceGridReadMore',
									label: 'Read More Link',
									values: [
										{text: 'Yes', value: 'true'},
										{text: 'No', value: 'false'}
									]
								},
                                // Background Color
                                {
                                    type: 'textbox',
                                    name: 'serviceGridBackgroundColor',
                                    label: 'Service Grid: Background Color Hex',
                                    value: ''
                                },
                                // Border Color
                                {
                                    type: 'textbox',
                                    name: 'serviceGridBorderColor',
                                    label: 'Service Grid: Border Color Hex',
                                    value: ''
                                }
                                ],
                                onsubmit: function( e ) {
                                    editor.insertContent('[ttbase_service_grid style="' + e.data.serviceGridStyle + '" columns="' + e.data.serviceGridColumns + '" services="' + e.data.serviceGridPosts + '" pagination="' + e.data.serviceGridPagination + '" categories="' + e.data.serviceGridCategories + '" order="' + e.data.serviceGridOrder + '" orderby="' + e.data.serviceGridOrderBy + '" showfilter="' + e.data.serviceGridShowFilter + '" img_crop="' + e.data.serviceGridImageCrop + '" img_width="' + e.data.serviceGridImageWidth + '" img_height="' + e.data.serviceGridImageHeight + '" img_padding="' + e.data.serviceGridImagePadding + '" excerpt="' + e.data.serviceGridExcerpt + '" excerpt_length="' + e.data.serviceGridExcerptLength + '" read_more="' + e.data.serviceGridReadMore + '" background="' + e.data.serviceGridBackgroundColor + '" border="' + e.data.serviceGridBorderColor + '"]');
                                }
                            });
                        }
                    }, // End Service Grid

                    /* Post Carousel */
                    {
                        text: 'Post Carousel',
                        onclick: function() {
                            editor.windowManager.open( {
                                title: 'TTBase Shortcodes - Insert Post Carousel',
                                body: [
                                    // Parent Category
                                    {
                                        type: 'textbox',
                                        name: 'postCategories',
                                        label: 'Post Carousel: Categories',
                                        values: 'all'
                                    },
                                    // Post Max Items
                                    {
                                        type: 'textbox',
                                        name: 'postMaxItems',
                                        label: 'Post Carousel: Max Items',
                                        value: ''
                                    },
                                    // Background Color
                                    {
                                        type: 'textbox',
                                        name: 'postBackgroundColor',
                                        label: 'Background Color Hex',
                                        value: '#ffffff'
                                    },
                                    // Post Carousel Image Style
                                    {
                                        type: 'listbox',
                                        name: 'postImageStyle',
                                        label: 'Post Carousel: Image Style',
                                        values: [
                                            {text: 'Colored', value: 'color'},
                                            {text: 'Grayscale', value: 'grayscale'}
                                        ]
                                    },
                                    // Post Carousel Image Crop
                                    {
                                        type: 'listbox',
                                        name: 'postImageCrop',
                                        label: 'Post Carousel: Image Crop',
                                        values: [
                                            {text: 'Yes', value: 'true'},
                                            {text: 'No', value: 'false'}
                                        ]
                                    },
                                    // Post Image Width
                                    {
                                        type: 'textbox',
                                        name: 'postImageWidth',
                                        label: 'Post Carousel: Image Width',
                                        value: ''
                                    },
                                    // Post Image Height
                                    {
                                        type: 'textbox',
                                        name: 'postImageHeight',
                                        label: 'Post Carousel: Image Height',
                                        value: ''
                                    },
                                ],
                                onsubmit: function( e ) {
                                    editor.insertContent('[ttbase_post_carousel categories="' + e.data.postCategories + '" background="' + e.data.postBackgroundColor + '" img_style="' + e.data.postImageStyle + '" img_crop="' + e.data.postImageCrop + '" img_width="' + e.data.postImageWidth + '" img_height="' + e.data.postImageHeight + '" posts="' + e.data.postMaxItems + '"]');
                                }
                            });
                        }
                    }, // End Post Carousel

					/* Posts Grid */
					{
						text: 'Posts Grid',
						onclick: function() {
							editor.windowManager.open( {
								title: 'TTBase Shortcodes - Posts Grid',
								autoScroll: true,
								height: 450,
								width: 450,
								body: [

								// Posts Grid Image Style
								{
									type: 'listbox',
									name: 'postsGridImageStyle',
									label: 'Image Style',
									values: [
										{text: 'Colored', value: 'default'},
										{text: 'Grayscale', value: 'grayscale'}
									]
								},

								// Posts Grid Taxonomy
								{
									type: 'textbox',
									name: 'postsGridTaxonomy',
									label: 'Filter by: Taxonomy Name',
									value: ''
								},

								// Posts Grid Taxonomy
								{
									type: 'textbox',
									name: 'postsGridTermSlug',
									label: 'Filter by: Term Slug',
									value: ''
								},

								// Posts Grid Count
								{
									type: 'textbox',
									name: 'postsGridCount',
									label: 'Posts Per Page',
									value: '12'
								},

								// Posts Grid Pagination
								{
									type: 'listbox',
									name: 'postsGridPagination',
									label: 'Paginate?',
									values: [
										{text: 'No', value: 'false'},
										{text: 'Yes', value: 'true'}
									]
								},

								// Posts Grid Order
								{
									type: 'listbox',
									name: 'postsGridOrder',
									label: 'Order',
									values: [
										{text: 'Descending', value: 'DESC'},
										{text: 'Ascending', value: 'ASC'}
									]
								},

								// Posts Grid Order by
								{
									type: 'listbox',
									name: 'postsGridOrderBy',
									label: 'Order By',
									values: [
										{text: 'Date', value: 'date'},
										{text: 'Name', value: 'name'},
										{text: 'Modified', value: 'modified'},
										{text: 'Author', value: 'author'},
										{text: 'Random', value: 'random'},
										{text: 'Comment Count', value: 'comment_count'}
									]
								},

								// Posts Grid Columns
								{
									type: 'listbox',
									name: 'postsGridColumns',
									label: 'Columns',
									values: [
										{text: '1', value: '1'},
										{text: '2', value: '2'},
										{text: '3', value: '3'},
										{text: '4', value: '4'},
										{text: '5', value: '5'},
										{text: '6', value: '6'}
									]
								},

								// Posts Grid Thumbnail Crop
								{
									type: 'listbox',
									name: 'postsGridThumbnailCrop',
									label: 'Thumbnail Crop',
									values: [
										{text: 'Yes', value: 'true'},
										{text: 'No', value: 'false'}
									]
								},

								// Posts Grid Thumbnail Height
								{
									type: 'textbox',
									name: 'postsGridThumbnailHeight',
									label: 'Thumbnail Height',
									value: '9999'
								},

								// Posts Grid Thumbnail Width
								{
									type: 'textbox',
									name: 'postsGridThumbnailWidth',
									label: 'Thumbnail Width',
									value: '9999'
								},

								// Posts Grid Title
								{
									type: 'listbox',
									name: 'postsGridTitle',
									label: 'Display Title?',
									values: [
										{text: 'Yes', value: 'true'},
										{text: 'No', value: 'false'}
									]
								},

								// Posts Grid Excerpt
								{
									type: 'listbox',
									name: 'postsGridExcerpt',
									label: 'Display Excerpt?',
									values: [
										{text: 'Yes', value: 'true'},
										{text: 'No', value: 'false'}
									]
								},

								// Posts Grid Excerpt
								{
									type: 'textbox',
									name: 'postsGridExcerptLength',
									label: 'Excerpt Length',
									value: '30'
								},

								// Posts Grid Read More Link
								{
									type: 'listbox',
									name: 'postsGridReadMore',
									label: 'Read More Link',
									values: [
										{text: 'Yes', value: 'true'},
										{text: 'No', value: 'false'}
									]
								}

								],
								onsubmit: function( e ) {
									editor.insertContent('[ttbase_posts_grid style="' + e.data.postsGridImageStyle + '" taxonomy="' + e.data.postsGridTaxonomy + '" term_slug="' + e.data.postsGridTermSlug + '" count="' + e.data.postsGridCount + '" columns="' + e.data.postsGridColumns + '" pagination="' + e.data.postsGridPagination + '" order="' + e.data.postsGridOrder + '" orderby="' + e.data.postsGridOrderBy + '" img_crop="' + e.data.postsGridThumbnailCrop + '" img_height="' + e.data.postsGridThumbnailHeight + '" img_width="' + e.data.postsGridThumbnailWidth + '" title="' + e.data.postsGridTitle + '" excerpt="' + e.data.postsGridExcerpt + '" excerpt_length="' + e.data.postsGridExcerptLength + '" read_more="' + e.data.postsGridReadMore + '"]');
								}
							});
						}
					},
					/* Blog */
					{
						text: 'Blog',
						onclick: function() {
							editor.windowManager.open( {
								title: 'TTBase Shortcodes - Blog',
								autoScroll: true,
								height: 450,
								width: 450,
								body: [
                                
                                // Blog Count
								{
									type: 'textbox',
									name: 'blogPosts',
									label: 'Number of Posts',
									value: '8'
								},
								
								// Blog Type
								{
									type: 'listbox',
									name: 'blogType',
									label: 'Display Type',
									values: [
										{text: 'Normal Feed, No Sidebar', value: 'normal'},
										{text: 'Normal Feed, Left Sidebar', value: 'normal-left'},
										{text: 'Normal Feed, Right Sidebar', value: 'normal-right'},
										{text: 'Masonry Left Sidebar', value: 'masonry-2-col-left'},
										{text: 'Masonry Right Sidebar', value: 'masonry-2-col-right'},
										{text: 'Masonry 2 Columns', value: 'masonry-2-col'},
										{text: 'Masonry 3 Columns', value: 'masonry-3-col'},
										{text: 'Medium Images, No Sidebar', value: 'medium'},
										{text: 'Medium Images, Left Sidebar', value: 'medium-left'},
										{text: 'Medium Images, Right Sidebar', value: 'medium-right'}
										
									]
								},

								// Blog Pagination
								{
									type: 'listbox',
									name: 'blogPagination',
									label: 'Paginate?',
									values: [
										{text: 'No', value: 'no'},
										{text: 'Yes', value: 'yes'}
									]
								}
								],
								onsubmit: function( e ) {
									editor.insertContent('[ttbase_blog type="' + e.data.blogType + '" pppage="' + e.data.blogPosts + '" pagination="' + e.data.blogPagination + '"]');
								}
							});
						}
					}

					]
				}, // End Posts section

			]
		});
	});
})();