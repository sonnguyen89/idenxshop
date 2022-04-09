/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {
//Body
wp.customize("body_typography[font-weight]", function(e) {
    $currentVal = $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("font-weight", e);
        } else {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("font-weight", "");
        }
    });
});
wp.customize("body_typography[font-style]", function(e) {
    $currentVal = $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("font-style");
    e.bind(function(e) {
        if (e) {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("font-style", e);
        } else {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("font-style", "");
        }
    });
});
wp.customize("body_typography[font-size]", function(e) {
    $currentVal = $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("font-size");
    e.bind(function(e) {
        if (e) {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("font-size", parseInt(e, 10) + "px");
        } else {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("font-size", "");
        }
    });
});
wp.customize("body_typography[color]", function(e) {
    $currentVal = $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("color");
    e.bind(function(e) {
        if (e) {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("color", e);
        } else {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("color", "");
        }
    });
});
wp.customize("body_typography[line-height]", function(e) {
    $currentVal = $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("line-height");
    e.bind(function(e) {
        if (e) {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("line-height", e);
        } else {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("line-height", "");
        }
    });
});
wp.customize("body_typography[letter-spacing]", function(e) {
    $currentVal = $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("letter-spacing", "");
        }
    });
});
wp.customize("body_typography[text-transform]", function(e) {
    $currentVal = $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("text-transform", e);
        } else {
            $("body,h1,h2,h3,h4,h5,.header_text_wrapper h1,.header_text_wrapper .subtitle,.btn-primary, .menu-button, .gform_button,.woocommerce input.button.alt,input[type=submit],.icons-tabs .tab-title span,.vc_tta.vc_general .vc_tta-panel-title,.vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a,.nav-menu li a,.site-footer .widget .title").css("text-transform", "");
        }
    });
});

//Paragraph
wp.customize("paragraph_typography[font-weight]", function(e) {
    $currentVal = $("p,.textwidget").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $("p,.textwidget").css("font-weight", e);
        } else {
            $("p,.textwidget").css("font-weight", "");
        }
    });
});
wp.customize("paragraph_typography[font-style]", function(e) {
    $currentVal = $("p,.textwidget").css("font-style");
    e.bind(function(e) {
        if (e) {
            $("p,.textwidget").css("font-style", e);
        } else {
            $("p,.textwidget").css("font-style", "");
        }
    });
});
wp.customize("paragraph_typography[font-size]", function(e) {
    $currentVal = $("p,.textwidget").css("font-size");
    e.bind(function(e) {
        if (e) {
            $("p,.textwidget").css("font-size", parseInt(e, 10) + "px");
        } else {
            $("p,.textwidget").css("font-size", "");
        }
    });
});
wp.customize("paragraph_typography[color]", function(e) {
    $currentVal = $("p,.textwidget").css("color");
    e.bind(function(e) {
        if (e) {
            $("p,.textwidget").css("color", e);
        } else {
            $("p,.textwidget").css("color", "");
        }
    });
});
wp.customize("paragraph_typography[line-height]", function(e) {
    $currentVal = $("p,.textwidget").css("line-height");
    e.bind(function(e) {
        if (e) {
            $("p,.textwidget").css("line-height", e);
        } else {
            $("p,.textwidget").css("line-height", "");
        }
    });
});
wp.customize("paragraph_typography[letter-spacing]", function(e) {
    $currentVal = $("p,.textwidget").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $("p,.textwidget").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $("p,.textwidget").css("letter-spacing", "");
        }
    });
});
wp.customize("paragraph_typography[text-transform]", function(e) {
    $currentVal = $("p,.textwidget").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $("p,.textwidget").css("text-transform", e);
        } else {
            $("p,.textwidget").css("text-transform", "");
        }
    });
});

//Intro
wp.customize("intro_typography[font-weight]", function(e) {
    $currentVal = $(".intro").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".intro").css("font-weight", e);
        } else {
            $(".intro").css("font-weight", "");
        }
    });
});
wp.customize("intro_typography[font-style]", function(e) {
    $currentVal = $(".intro").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".intro").css("font-style", e);
        } else {
            $(".intro").css("font-style", "");
        }
    });
});
wp.customize("intro_typography[font-size]", function(e) {
    $currentVal = $(".intro").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".intro").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".intro").css("font-size", "");
        }
    });
});
wp.customize("intro_typography[color]", function(e) {
    $currentVal = $(".intro").css("color");
    e.bind(function(e) {
        if (e) {
            $(".intro").css("color", e);
        } else {
            $(".intro").css("color", "");
        }
    });
});
wp.customize("intro_typography[line-height]", function(e) {
    $currentVal = $(".intro").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".intro").css("line-height", e);
        } else {
            $(".intro").css("line-height", "");
        }
    });
});
wp.customize("intro_typography[letter-spacing]", function(e) {
    $currentVal = $(".intro").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".intro").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".intro").css("letter-spacing", "");
        }
    });
});
wp.customize("intro_typography[text-transform]", function(e) {
    $currentVal = $(".intro").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".intro").css("text-transform", e);
        } else {
            $(".intro").css("text-transform", "");
        }
    });
});

//Header XL Page Title
wp.customize("headings_xl_title_typography[font-weight]", function(e) {
    $currentVal = $(".x-large .header_text_wrapper h1").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".x-large .header_text_wrapper h1").css("font-weight", e);
        } else {
            $(".x-large .header_text_wrapper h1").css("font-weight", "");
        }
    });
});
wp.customize("headings_xl_title_typography[font-style]", function(e) {
    $currentVal = $(".x-large .header_text_wrapper h1").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".x-large .header_text_wrapper h1").css("font-style", e);
        } else {
            $(".x-large .header_text_wrapper h1").css("font-style", "");
        }
    });
});
wp.customize("headings_xl_title_typography[font-size]", function(e) {
    $currentVal = $(".x-large .header_text_wrapper h1").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".x-large .header_text_wrapper h1").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".x-large .header_text_wrapper h1").css("font-size", "");
        }
    });
});
wp.customize("headings_xl_title_typography[color]", function(e) {
    $currentVal = $(".x-large .header_text_wrapper h1").css("color");
    e.bind(function(e) {
        if (e) {
            $(".x-large .header_text_wrapper h1").css("color", e);
        } else {
            $(".x-large .header_text_wrapper h1").css("color", "");
        }
    });
});
wp.customize("headings_xl_title_typography[line-height]", function(e) {
    $currentVal = $(".x-large .header_text_wrapper h1").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".x-large .header_text_wrapper h1").css("line-height", e);
        } else {
            $(".x-large .header_text_wrapper h1").css("line-height", "");
        }
    });
});
wp.customize("headings_xl_title_typography[letter-spacing]", function(e) {
    $currentVal = $(".x-large .header_text_wrapper h1").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".x-large .header_text_wrapper h1").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".x-large .header_text_wrapper h1").css("letter-spacing", "");
        }
    });
});
wp.customize("headings_xl_title_typography[text-transform]", function(e) {
    $currentVal = $(".x-large .header_text_wrapper h1").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".x-large .header_text_wrapper h1").css("text-transform", e);
        } else {
            $(".x-large .header_text_wrapper h1").css("text-transform", "");
        }
    });
});

//Header X-Large Subtitle
wp.customize("headings_xl_subtitle_typography[font-weight]", function(e) {
    $currentVal = $(".header_text_wrapper .subtitle").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".header_text_wrapper .subtitle").css("font-weight", e);
        } else {
            $(".header_text_wrapper .subtitle").css("font-weight", "");
        }
    });
});
wp.customize("headings_xl_subtitle_typography[font-style]", function(e) {
    $currentVal = $(".header_text_wrapper .subtitle").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".header_text_wrapper .subtitle").css("font-style", e);
        } else {
            $(".header_text_wrapper .subtitle").css("font-style", "");
        }
    });
});
wp.customize("headings_xl_subtitle_typography[font-size]", function(e) {
    $currentVal = $(".header_text_wrapper .subtitle").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".header_text_wrapper .subtitle").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".header_text_wrapper .subtitle").css("font-size", "");
        }
    });
});
wp.customize("headings_xl_subtitle_typography[color]", function(e) {
    $currentVal = $(".header_text_wrapper .subtitle").css("color");
    e.bind(function(e) {
        if (e) {
            $(".header_text_wrapper .subtitle").css("color", e);
        } else {
            $(".header_text_wrapper .subtitle").css("color", "");
        }
    });
});
wp.customize("headings_xl_subtitle_typography[line-height]", function(e) {
    $currentVal = $(".header_text_wrapper .subtitle").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".header_text_wrapper .subtitle").css("line-height", e);
        } else {
            $(".header_text_wrapper .subtitle").css("line-height", "");
        }
    });
});
wp.customize("headings_xl_subtitle_typography[letter-spacing]", function(e) {
    $currentVal = $(".header_text_wrapper .subtitle").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".header_text_wrapper .subtitle").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".header_text_wrapper .subtitle").css("letter-spacing", "");
        }
    });
});
wp.customize("headings_xl_subtitle_typography[text-transform]", function(e) {
    $currentVal = $(".header_text_wrapper .subtitle").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".header_text_wrapper .subtitle").css("text-transform", e);
        } else {
            $(".header_text_wrapper .subtitle").css("text-transform", "");
        }
    });
});

//Header Large Page Title
wp.customize("headings_large_title_typography[font-weight]", function(e) {
    $currentVal = $(".large .header_text_wrapper h1").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".large .header_text_wrapper h1").css("font-weight", e);
        } else {
            $(".large .header_text_wrapper h1").css("font-weight", "");
        }
    });
});
wp.customize("headings_large_title_typography[font-style]", function(e) {
    $currentVal = $(".large .header_text_wrapper h1").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".large .header_text_wrapper h1").css("font-style", e);
        } else {
            $(".large .header_text_wrapper h1").css("font-style", "");
        }
    });
});
wp.customize("headings_large_title_typography[font-size]", function(e) {
    $currentVal = $(".large .header_text_wrapper h1").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".large .header_text_wrapper h1").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".large .header_text_wrapper h1").css("font-size", "");
        }
    });
});
wp.customize("headings_large_title_typography[color]", function(e) {
    $currentVal = $(".large .header_text_wrapper h1").css("color");
    e.bind(function(e) {
        if (e) {
            $(".large .header_text_wrapper h1").css("color", e);
        } else {
            $(".large .header_text_wrapper h1").css("color", "");
        }
    });
});
wp.customize("headings_large_title_typography[line-height]", function(e) {
    $currentVal = $(".large .header_text_wrapper h1").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".large .header_text_wrapper h1").css("line-height", e);
        } else {
            $(".large .header_text_wrapper h1").css("line-height", "");
        }
    });
});
wp.customize("headings_large_title_typography[letter-spacing]", function(e) {
    $currentVal = $(".large .header_text_wrapper h1").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".large .header_text_wrapper h1").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".large .header_text_wrapper h1").css("letter-spacing", "");
        }
    });
});
wp.customize("headings_large_title_typography[text-transform]", function(e) {
    $currentVal = $(".large .header_text_wrapper h1").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".large .header_text_wrapper h1").css("text-transform", e);
        } else {
            $(".large .header_text_wrapper h1").css("text-transform", "");
        }
    });
});

//Header Small Page Title
wp.customize("headings_small_title_typography[font-weight]", function(e) {
    $currentVal = $(".small .header_text_wrapper h1").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".small .header_text_wrapper h1").css("font-weight", e);
        } else {
            $(".small .header_text_wrapper h1").css("font-weight", "");
        }
    });
});
wp.customize("headings_small_title_typography[font-style]", function(e) {
    $currentVal = $(".small .header_text_wrapper h1").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".small .header_text_wrapper h1").css("font-style", e);
        } else {
            $(".small .header_text_wrapper h1").css("font-style", "");
        }
    });
});
wp.customize("headings_small_title_typography[font-size]", function(e) {
    $currentVal = $(".small .header_text_wrapper h1").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".small .header_text_wrapper h1").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".small .header_text_wrapper h1").css("font-size", "");
        }
    });
});
wp.customize("headings_small_title_typography[color]", function(e) {
    $currentVal = $(".small .header_text_wrapper h1").css("color");
    e.bind(function(e) {
        if (e) {
            $(".small .header_text_wrapper h1").css("color", e);
        } else {
            $(".small .header_text_wrapper h1").css("color", "");
        }
    });
});
wp.customize("headings_small_title_typography[line-height]", function(e) {
    $currentVal = $(".small .header_text_wrapper h1").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".small .header_text_wrapper h1").css("line-height", e);
        } else {
            $(".small .header_text_wrapper h1").css("line-height", "");
        }
    });
});
wp.customize("headings_small_title_typography[letter-spacing]", function(e) {
    $currentVal = $(".small .header_text_wrapper h1").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".small .header_text_wrapper h1").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".small .header_text_wrapper h1").css("letter-spacing", "");
        }
    });
});
wp.customize("headings_small_title_typography[text-transform]", function(e) {
    $currentVal = $(".small .header_text_wrapper h1").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".small .header_text_wrapper h1").css("text-transform", e);
        } else {
            $(".small .header_text_wrapper h1").css("text-transform", "");
        }
    });
});

//Header X-Small Page Title
wp.customize("headings_xs_title_typography[font-weight]", function(e) {
    $currentVal = $(".x-small .header_text_wrapper h1").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".x-small .header_text_wrapper h1").css("font-weight", e);
        } else {
            $(".x-small .header_text_wrapper h1").css("font-weight", "");
        }
    });
});
wp.customize("headings_xs_title_typography[font-style]", function(e) {
    $currentVal = $(".x-small .header_text_wrapper h1").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".x-small .header_text_wrapper h1").css("font-style", e);
        } else {
            $(".x-small .header_text_wrapper h1").css("font-style", "");
        }
    });
});
wp.customize("headings_xs_title_typography[font-size]", function(e) {
    $currentVal = $(".x-small .header_text_wrapper h1").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".x-small .header_text_wrapper h1").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".x-small .header_text_wrapper h1").css("font-size", "");
        }
    });
});
wp.customize("headings_xs_title_typography[color]", function(e) {
    $currentVal = $(".x-small .header_text_wrapper h1").css("color");
    e.bind(function(e) {
        if (e) {
            $(".x-small .header_text_wrapper h1").css("color", e);
        } else {
            $(".x-small .header_text_wrapper h1").css("color", "");
        }
    });
});
wp.customize("headings_xs_title_typography[line-height]", function(e) {
    $currentVal = $(".x-small .header_text_wrapper h1").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".x-small .header_text_wrapper h1").css("line-height", e);
        } else {
            $(".x-small .header_text_wrapper h1").css("line-height", "");
        }
    });
});
wp.customize("headings_xs_title_typography[letter-spacing]", function(e) {
    $currentVal = $(".x-small .header_text_wrapper h1").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".x-small .header_text_wrapper h1").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".x-small .header_text_wrapper h1").css("letter-spacing", "");
        }
    });
});
wp.customize("headings_xs_title_typography[text-transform]", function(e) {
    $currentVal = $(".x-small .header_text_wrapper h1").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".x-small .header_text_wrapper h1").css("text-transform", e);
        } else {
            $(".x-small .header_text_wrapper h1").css("text-transform", "");
        }
    });
});

//Heading h2
wp.customize("headings2_typography[font-weight]", function(e) {
    $currentVal = $("h2").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $("h2").css("font-weight", e);
        } else {
            $("h2").css("font-weight", "");
        }
    });
});
wp.customize("headings2_typography[font-style]", function(e) {
    $currentVal = $("h2").css("font-style");
    e.bind(function(e) {
        if (e) {
            $("h2").css("font-style", e);
        } else {
            $("h2").css("font-style", "");
        }
    });
});
wp.customize("headings2_typography[font-size]", function(e) {
    $currentVal = $("h2").css("font-size");
    e.bind(function(e) {
        if (e) {
            $("h2").css("font-size", parseInt(e, 10) + "px");
        } else {
            $("h2").css("font-size", "");
        }
    });
});
wp.customize("headings2_typography[color]", function(e) {
    $currentVal = $("h2").css("color");
    e.bind(function(e) {
        if (e) {
            $("h2").css("color", e);
        } else {
            $("h2").css("color", "");
        }
    });
});
wp.customize("headings2_typography[line-height]", function(e) {
    $currentVal = $("h2").css("line-height");
    e.bind(function(e) {
        if (e) {
            $("h2").css("line-height", e);
        } else {
            $("h2").css("line-height", "");
        }
    });
});
wp.customize("headings2_typography[letter-spacing]", function(e) {
    $currentVal = $("h2").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $("h2").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $("h2").css("letter-spacing", "");
        }
    });
});
wp.customize("headings2_typography[text-transform]", function(e) {
    $currentVal = $("h2").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $("h2").css("text-transform", e);
        } else {
            $("h2").css("text-transform", "");
        }
    });
});

//Headings h3
wp.customize("headings3_typography[font-weight]", function(e) {
    $currentVal = $("h3").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $("h3").css("font-weight", e);
        } else {
            $("h3").css("font-weight", "");
        }
    });
});
wp.customize("headings3_typography[font-style]", function(e) {
    $currentVal = $("h3").css("font-style");
    e.bind(function(e) {
        if (e) {
            $("h3").css("font-style", e);
        } else {
            $("h3").css("font-style", "");
        }
    });
});
wp.customize("headings3_typography[font-size]", function(e) {
    $currentVal = $("h3").css("font-size");
    e.bind(function(e) {
        if (e) {
            $("h3").css("font-size", parseInt(e, 10) + "px");
        } else {
            $("h3").css("font-size", "");
        }
    });
});
wp.customize("headings3_typography[color]", function(e) {
    $currentVal = $("h3").css("color");
    e.bind(function(e) {
        if (e) {
            $("h3").css("color", e);
        } else {
            $("h3").css("color", "");
        }
    });
});
wp.customize("headings3_typography[line-height]", function(e) {
    $currentVal = $("h3").css("line-height");
    e.bind(function(e) {
        if (e) {
            $("h3").css("line-height", e);
        } else {
            $("h3").css("line-height", "");
        }
    });
});
wp.customize("headings3_typography[letter-spacing]", function(e) {
    $currentVal = $("h3").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $("h3").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $("h3").css("letter-spacing", "");
        }
    });
});
wp.customize("headings3_typography[text-transform]", function(e) {
    $currentVal = $("h3").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $("h3").css("text-transform", e);
        } else {
            $("h3").css("text-transform", "");
        }
    });
});

//Headings h4
wp.customize("headings4_typography[font-weight]", function(e) {
    $currentVal = $("h4").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $("h4").css("font-weight", e);
        } else {
            $("h4").css("font-weight", "");
        }
    });
});
wp.customize("headings4_typography[font-style]", function(e) {
    $currentVal = $("h4").css("font-style");
    e.bind(function(e) {
        if (e) {
            $("h4").css("font-style", e);
        } else {
            $("h4").css("font-style", "");
        }
    });
});
wp.customize("headings4_typography[font-size]", function(e) {
    $currentVal = $("h4").css("font-size");
    e.bind(function(e) {
        if (e) {
            $("h4").css("font-size", parseInt(e, 10) + "px");
        } else {
            $("h4").css("font-size", "");
        }
    });
});
wp.customize("headings4_typography[color]", function(e) {
    $currentVal = $("h4").css("color");
    e.bind(function(e) {
        if (e) {
            $("h4").css("color", e);
        } else {
            $("h4").css("color", "");
        }
    });
});
wp.customize("headings4_typography[line-height]", function(e) {
    $currentVal = $("h4").css("line-height");
    e.bind(function(e) {
        if (e) {
            $("h4").css("line-height", e);
        } else {
            $("h4").css("line-height", "");
        }
    });
});
wp.customize("headings4_typography[letter-spacing]", function(e) {
    $currentVal = $("h4").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $("h4").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $("h4").css("letter-spacing", "");
        }
    });
});
wp.customize("headings4_typography[text-transform]", function(e) {
    $currentVal = $("h4").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $("h4").css("text-transform", e);
        } else {
            $("h4").css("text-transform", "");
        }
    });
});

//Headings h5
wp.customize("headings5_typography[font-weight]", function(e) {
    $currentVal = $("h5").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $("h5").css("font-weight", e);
        } else {
            $("h5").css("font-weight", "");
        }
    });
});
wp.customize("headings5_typography[font-style]", function(e) {
    $currentVal = $("h5").css("font-style");
    e.bind(function(e) {
        if (e) {
            $("h5").css("font-style", e);
        } else {
            $("h5").css("font-style", "");
        }
    });
});
wp.customize("headings5_typography[font-size]", function(e) {
    $currentVal = $("h5").css("font-size");
    e.bind(function(e) {
        if (e) {
            $("h5").css("font-size", parseInt(e, 10) + "px");
        } else {
            $("h5").css("font-size", "");
        }
    });
});
wp.customize("headings5_typography[color]", function(e) {
    $currentVal = $("h5").css("color");
    e.bind(function(e) {
        if (e) {
            $("h5").css("color", e);
        } else {
            $("h5").css("color", "");
        }
    });
});
wp.customize("headings5_typography[line-height]", function(e) {
    $currentVal = $("h5").css("line-height");
    e.bind(function(e) {
        if (e) {
            $("h5").css("line-height", e);
        } else {
            $("h5").css("line-height", "");
        }
    });
});
wp.customize("headings5_typography[letter-spacing]", function(e) {
    $currentVal = $("h5").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $("h5").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $("h5").css("letter-spacing", "");
        }
    });
});
wp.customize("headings5_typography[text-transform]", function(e) {
    $currentVal = $("h5").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $("h5").css("text-transform", e);
        } else {
            $("h5").css("text-transform", "");
        }
    });
});

//Main Menu
wp.customize("nav_menu_typography[font-weight]", function(e) {
    $currentVal = $(".nav-menu li a").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu li a").css("font-weight", e);
        } else {
            $(".nav-menu li a").css("font-weight", "");
        }
    });
});
wp.customize("nav_menu_typography[font-style]", function(e) {
    $currentVal = $(".nav-menu li a").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu li a").css("font-style", e);
        } else {
            $(".nav-menu li a").css("font-style", "");
        }
    });
});
wp.customize("nav_menu_typography[font-size]", function(e) {
    $currentVal = $(".nav-menu li a").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu li a").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".nav-menu li a").css("font-size", "");
        }
    });
});
wp.customize("nav_menu_typography[color]", function(e) {
    $currentVal = $(".nav-menu li a").css("color");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu li a").css("color", e);
        } else {
            $(".nav-menu li a").css("color", "");
        }
    });
});
wp.customize("nav_menu_typography[line-height]", function(e) {
    $currentVal = $(".nav-menu li a").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu li a").css("line-height", e);
        } else {
            $(".nav-menu li a").css("line-height", "");
        }
    });
});
wp.customize("nav_menu_typography[letter-spacing]", function(e) {
    $currentVal = $(".nav-menu li a").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu li a").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".nav-menu li a").css("letter-spacing", "");
        }
    });
});
wp.customize("nav_menu_typography[text-transform]", function(e) {
    $currentVal = $(".nav-menu li a").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu li a").css("text-transform", e);
        } else {
            $(".nav-menu li a").css("text-transform", "");
        }
    });
});

//Main Menu Dropdowns
wp.customize("menu_dropdown_typography[font-weight]", function(e) {
    $currentVal = $(".nav-menu ul ul li a").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu ul ul li a").css("font-weight", e);
        } else {
            $(".nav-menu ul ul li a").css("font-weight", "");
        }
    });
});
wp.customize("menu_dropdown_typography[font-style]", function(e) {
    $currentVal = $(".nav-menu ul ul li a").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu ul ul li a").css("font-style", e);
        } else {
            $(".nav-menu ul ul li a").css("font-style", "");
        }
    });
});
wp.customize("menu_dropdown_typography[font-size]", function(e) {
    $currentVal = $(".nav-menu ul ul li a").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu ul ul li a").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".nav-menu ul ul li a").css("font-size", "");
        }
    });
});
wp.customize("menu_dropdown_typography[color]", function(e) {
    $currentVal = $(".nav-menu ul ul li a").css("color");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu ul ul li a").css("color", e);
        } else {
            $(".nav-menu ul ul li a").css("color", "");
        }
    });
});
wp.customize("menu_dropdown_typography[line-height]", function(e) {
    $currentVal = $(".nav-menu ul ul li a").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu ul ul li a").css("line-height", e);
        } else {
            $(".nav-menu ul ul li a").css("line-height", "");
        }
    });
});
wp.customize("menu_dropdown_typography[letter-spacing]", function(e) {
    $currentVal = $(".nav-menu ul ul li a").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu ul ul li a").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".nav-menu ul ul li a").css("letter-spacing", "");
        }
    });
});
wp.customize("menu_dropdown_typography[text-transform]", function(e) {
    $currentVal = $(".nav-menu ul ul li a").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".nav-menu ul ul li a").css("text-transform", e);
        } else {
            $(".nav-menu ul ul li a").css("text-transform", "");
        }
    });
});

//Mobile Menu
wp.customize("mobile_menu_typography[font-weight]", function(e) {
    $currentVal = $(".mobile-nav .mobile-menu ul li a").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".mobile-nav .mobile-menu ul li a").css("font-weight", e);
        } else {
            $(".mobile-nav .mobile-menu ul li a").css("font-weight", "");
        }
    });
});
wp.customize("mobile_menu_typography[font-style]", function(e) {
    $currentVal = $(".mobile-nav .mobile-menu ul li a").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".mobile-nav .mobile-menu ul li a").css("font-style", e);
        } else {
            $(".mobile-nav .mobile-menu ul li a").css("font-style", "");
        }
    });
});
wp.customize("mobile_menu_typography[font-size]", function(e) {
    $currentVal = $(".mobile-nav .mobile-menu ul li a").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".mobile-nav .mobile-menu ul li a").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".mobile-nav .mobile-menu ul li a").css("font-size", "");
        }
    });
});
wp.customize("mobile_menu_typography[color]", function(e) {
    $currentVal = $(".mobile-nav .mobile-menu ul li a").css("color");
    e.bind(function(e) {
        if (e) {
            $(".mobile-nav .mobile-menu ul li a").css("color", e);
        } else {
            $(".mobile-nav .mobile-menu ul li a").css("color", "");
        }
    });
});
wp.customize("mobile_menu_typography[line-height]", function(e) {
    $currentVal = $(".mobile-nav .mobile-menu ul li a").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".mobile-nav .mobile-menu ul li a").css("line-height", e);
        } else {
            $(".mobile-nav .mobile-menu ul li a").css("line-height", "");
        }
    });
});
wp.customize("mobile_menu_typography[letter-spacing]", function(e) {
    $currentVal = $(".mobile-nav .mobile-menu ul li a").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".mobile-nav .mobile-menu ul li a").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".mobile-nav .mobile-menu ul li a").css("letter-spacing", "");
        }
    });
});
wp.customize("mobile_menu_typography[text-transform]", function(e) {
    $currentVal = $(".mobile-nav .mobile-menu ul li a").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".mobile-nav .mobile-menu ul li a").css("text-transform", e);
        } else {
            $(".mobile-nav .mobile-menu ul li a").css("text-transform", "");
        }
    });
});

//Sidebar Widget Heading
wp.customize("sidebar_widget_title_typography[font-weight]", function(e) {
    $currentVal = $(".sidebar .widget .title").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".sidebar .widget .title").css("font-weight", e);
        } else {
            $(".sidebar .widget .title").css("font-weight", "");
        }
    });
});
wp.customize("sidebar_widget_title_typography[font-style]", function(e) {
    $currentVal = $(".sidebar .widget .title").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".sidebar .widget .title").css("font-style", e);
        } else {
            $(".sidebar .widget .title").css("font-style", "");
        }
    });
});
wp.customize("sidebar_widget_title_typography[font-size]", function(e) {
    $currentVal = $(".sidebar .widget .title").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".sidebar .widget .title").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".sidebar .widget .title").css("font-size", "");
        }
    });
});
wp.customize("sidebar_widget_title_typography[color]", function(e) {
    $currentVal = $(".sidebar .widget .title").css("color");
    e.bind(function(e) {
        if (e) {
            $(".sidebar .widget .title").css("color", e);
        } else {
            $(".sidebar .widget .title").css("color", "");
        }
    });
});
wp.customize("sidebar_widget_title_typography[line-height]", function(e) {
    $currentVal = $(".sidebar .widget .title").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".sidebar .widget .title").css("line-height", e);
        } else {
            $(".sidebar .widget .title").css("line-height", "");
        }
    });
});
wp.customize("sidebar_widget_title_typography[letter-spacing]", function(e) {
    $currentVal = $(".sidebar .widget .title").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".sidebar .widget .title").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".sidebar .widget .title").css("letter-spacing", "");
        }
    });
});
wp.customize("sidebar_widget_title_typography[text-transform]", function(e) {
    $currentVal = $(".sidebar .widget .title").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".sidebar .widget .title").css("text-transform", e);
        } else {
            $(".sidebar .widget .title").css("text-transform", "");
        }
    });
});

//Footer Widget Heading
wp.customize("footer_widget_title_typography[font-weight]", function(e) {
    $currentVal = $(".site-footer .widget .title").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".site-footer .widget .title").css("font-weight", e);
        } else {
            $(".site-footer .widget .title").css("font-weight", "");
        }
    });
});
wp.customize("footer_widget_title_typography[font-style]", function(e) {
    $currentVal = $(".site-footer .widget .title").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".site-footer .widget .title").css("font-style", e);
        } else {
            $(".site-footer .widget .title").css("font-style", "");
        }
    });
});
wp.customize("footer_widget_title_typography[font-size]", function(e) {
    $currentVal = $(".site-footer .widget .title").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".site-footer .widget .title").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".site-footer .widget .title").css("font-size", "");
        }
    });
});
wp.customize("footer_widget_title_typography[color]", function(e) {
    $currentVal = $(".site-footer .widget .title").css("color");
    e.bind(function(e) {
        if (e) {
            $(".site-footer .widget .title").css("color", e);
        } else {
            $(".site-footer .widget .title").css("color", "");
        }
    });
});
wp.customize("footer_widget_title_typography[line-height]", function(e) {
    $currentVal = $(".site-footer .widget .title").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".site-footer .widget .title").css("line-height", e);
        } else {
            $(".site-footer .widget .title").css("line-height", "");
        }
    });
});
wp.customize("footer_widget_title_typography[letter-spacing]", function(e) {
    $currentVal = $(".site-footer .widget .title").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".site-footer .widget .title").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".site-footer .widget .title").css("letter-spacing", "");
        }
    });
});
wp.customize("footer_widget_title_typography[text-transform]", function(e) {
    $currentVal = $(".site-footer .widget .title").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".site-footer .widget .title").css("text-transform", e);
        } else {
            $(".site-footer .widget .title").css("text-transform", "");
        }
    });
});

//Footer paragraph
wp.customize("footer_paragraph_typography[font-weight]", function(e) {
    $currentVal = $(".site-footer p").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".site-footer p").css("font-weight", e);
        } else {
            $(".site-footer p").css("font-weight", "");
        }
    });
});
wp.customize("footer_paragraph_typography[font-style]", function(e) {
    $currentVal = $(".site-footer p").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".site-footer p").css("font-style", e);
        } else {
            $(".site-footer p").css("font-style", "");
        }
    });
});
wp.customize("footer_paragraph_typography[font-size]", function(e) {
    $currentVal = $(".site-footer p").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".site-footer p").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".site-footer p").css("font-size", "");
        }
    });
});
wp.customize("footer_paragraph_typography[color]", function(e) {
    $currentVal = $(".site-footer p").css("color");
    e.bind(function(e) {
        if (e) {
            $(".site-footer p").css("color", e);
        } else {
            $(".site-footer p").css("color", "");
        }
    });
});
wp.customize("footer_paragraph_typography[line-height]", function(e) {
    $currentVal = $(".site-footer p").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".site-footer p").css("line-height", e);
        } else {
            $(".site-footer p").css("line-height", "");
        }
    });
});
wp.customize("footer_paragraph_typography[letter-spacing]", function(e) {
    $currentVal = $(".site-footer p").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".site-footer p").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".site-footer p").css("letter-spacing", "");
        }
    });
});
wp.customize("footer_paragraph_typography[text-transform]", function(e) {
    $currentVal = $(".site-footer p").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".site-footer p").css("text-transform", e);
        } else {
            $(".site-footer p").css("text-transform", "");
        }
    });
});

//Footer lists
wp.customize("footer_list_typography[font-weight]", function(e) {
    $currentVal = $(".site-footer ul").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".site-footer ul").css("font-weight", e);
        } else {
            $(".site-footer ul").css("font-weight", "");
        }
    });
});
wp.customize("footer_list_typography[font-style]", function(e) {
    $currentVal = $(".site-footer ul").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".site-footer ul").css("font-style", e);
        } else {
            $(".site-footer ul").css("font-style", "");
        }
    });
});
wp.customize("footer_list_typography[font-size]", function(e) {
    $currentVal = $(".site-footer ul").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".site-footer ul").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".site-footer ul").css("font-size", "");
        }
    });
});
wp.customize("footer_list_typography[color]", function(e) {
    $currentVal = $(".site-footer ul").css("color");
    e.bind(function(e) {
        if (e) {
            $(".site-footer ul").css("color", e);
        } else {
            $(".site-footer ul").css("color", "");
        }
    });
});
wp.customize("footer_list_typography[line-height]", function(e) {
    $currentVal = $(".site-footer ul").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".site-footer ul").css("line-height", e);
        } else {
            $(".site-footer ul").css("line-height", "");
        }
    });
});
wp.customize("footer_list_typography[letter-spacing]", function(e) {
    $currentVal = $(".site-footer ul").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".site-footer ul").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".site-footer ul").css("letter-spacing", "");
        }
    });
});
wp.customize("footer_list_typography[text-transform]", function(e) {
    $currentVal = $(".site-footer ul").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".site-footer ul").css("text-transform", e);
        } else {
            $(".site-footer ul").css("text-transform", "");
        }
    });
});

//Blog post title
wp.customize("blog_post_title_typography[font-weight]", function(e) {
    $currentVal = $(".blog-normal .content-wrap .entry-title").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".blog-normal .content-wrap .entry-title").css("font-weight", e);
        } else {
            $(".blog-normal .content-wrap .entry-title").css("font-weight", "");
        }
    });
});
wp.customize("blog_post_title_typography[font-style]", function(e) {
    $currentVal = $(".blog-normal .content-wrap .entry-title").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".blog-normal .content-wrap .entry-title").css("font-style", e);
        } else {
            $(".blog-normal .content-wrap .entry-title").css("font-style", "");
        }
    });
});
wp.customize("blog_post_title_typography[font-size]", function(e) {
    $currentVal = $(".blog-normal .content-wrap .entry-title").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".blog-normal .content-wrap .entry-title").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".blog-normal .content-wrap .entry-title").css("font-size", "");
        }
    });
});
wp.customize("blog_post_title_typography[color]", function(e) {
    $currentVal = $(".blog-normal .content-wrap .entry-title").css("color");
    e.bind(function(e) {
        if (e) {
            $(".blog-normal .content-wrap .entry-title").css("color", e);
        } else {
            $(".blog-normal .content-wrap .entry-title").css("color", "");
        }
    });
});
wp.customize("blog_post_title_typography[line-height]", function(e) {
    $currentVal = $(".blog-normal .content-wrap .entry-title").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".blog-normal .content-wrap .entry-title").css("line-height", e);
        } else {
            $(".blog-normal .content-wrap .entry-title").css("line-height", "");
        }
    });
});
wp.customize("blog_post_title_typography[letter-spacing]", function(e) {
    $currentVal = $(".blog-normal .content-wrap .entry-title").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".blog-normal .content-wrap .entry-title").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".blog-normal .content-wrap .entry-title").css("letter-spacing", "");
        }
    });
});
wp.customize("blog_post_title_typography[text-transform]", function(e) {
    $currentVal = $(".blog-normal .content-wrap .entry-title").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".blog-normal .content-wrap .entry-title").css("text-transform", e);
        } else {
            $(".blog-normal .content-wrap .entry-title").css("text-transform", "");
        }
    });
});

//Copyright
wp.customize("copyright_typography[font-weight]", function(e) {
    $currentVal = $(".site-info").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".site-info").css("font-weight", e);
        } else {
            $(".site-info").css("font-weight", "");
        }
    });
});
wp.customize("copyright_typography[font-style]", function(e) {
    $currentVal = $(".site-info").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".site-info").css("font-style", e);
        } else {
            $(".site-info").css("font-style", "");
        }
    });
});
wp.customize("copyright_typography[font-size]", function(e) {
    $currentVal = $(".site-info").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".site-info").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".site-info").css("font-size", "");
        }
    });
});
wp.customize("copyright_typography[color]", function(e) {
    $currentVal = $(".site-info").css("color");
    e.bind(function(e) {
        if (e) {
            $(".site-info").css("color", e);
        } else {
            $(".site-info").css("color", "");
        }
    });
});
wp.customize("copyright_typography[line-height]", function(e) {
    $currentVal = $(".site-info").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".site-info").css("line-height", e);
        } else {
            $(".site-info").css("line-height", "");
        }
    });
});
wp.customize("copyright_typography[letter-spacing]", function(e) {
    $currentVal = $(".site-info").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".site-info").css("letter-spacing", parseInt(e, 10) );
        } else {
            $(".site-info").css("letter-spacing", "");
        }
    });
});
wp.customize("copyright_typography[text-transform]", function(e) {
    $currentVal = $(".site-info").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".site-info").css("text-transform", e);
        } else {
            $(".site-info").css("text-transform", "");
        }
    });
});

//Primary button
wp.customize("button_typography[font-weight]", function(e) {
    $currentVal = $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("font-weight", e);
        } else {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("font-weight", "");
        }
    });
});
wp.customize("button_typography[font-style]", function(e) {
    $currentVal = $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("font-style", e);
        } else {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("font-style", "");
        }
    });
});
wp.customize("button_typography[font-size]", function(e) {
    $currentVal = $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("font-size", "");
        }
    });
});
wp.customize("button_typography[color]", function(e) {
    $currentVal = $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("color");
    e.bind(function(e) {
        if (e) {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("color", e);
        } else {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("color", "");
        }
    });
});
wp.customize("button_typography[line-height]", function(e) {
    $currentVal = $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("line-height", e);
        } else {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("line-height", "");
        }
    });
});
wp.customize("button_typography[letter-spacing]", function(e) {
    $currentVal = $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("letter-spacing", "");
        }
    });
});
wp.customize("button_typography[text-transform]", function(e) {
    $currentVal = $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("text-transform", e);
        } else {
            $(".btn-primary, .menu-button, .gform_button, .woocommerce input.button.alt, input[type=submit], .nav-menu li.menu-button a, button.single_add_to_cart_button").css("text-transform", "");
        }
    });
});

//Accordions & Tabs
wp.customize("tab_typography[font-weight]", function(e) {
    $currentVal = $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("font-weight", e);
        } else {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("font-weight", "");
        }
    });
});
wp.customize("tab_typography[font-style]", function(e) {
    $currentVal = $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("font-style");
    e.bind(function(e) {
        if (e) {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("font-style", e);
        } else {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("font-style", "");
        }
    });
});
wp.customize("tab_typography[font-size]", function(e) {
    $currentVal = $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("font-size");
    e.bind(function(e) {
        if (e) {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("font-size", parseInt(e, 10) + "px");
        } else {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("font-size", "");
        }
    });
});
wp.customize("tab_typography[color]", function(e) {
    $currentVal = $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("color");
    e.bind(function(e) {
        if (e) {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("color", e);
        } else {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("color", "");
        }
    });
});
wp.customize("tab_typography[line-height]", function(e) {
    $currentVal = $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("line-height");
    e.bind(function(e) {
        if (e) {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("line-height", e);
        } else {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("line-height", "");
        }
    });
});
wp.customize("tab_typography[letter-spacing]", function(e) {
    $currentVal = $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("letter-spacing", "");
        }
    });
});
wp.customize("tab_typography[text-transform]", function(e) {
    $currentVal = $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("text-transform", e);
        } else {
            $(".vc_tta.vc_general .vc_tta-panel-title, .icons-tabs .tab-title span, .vc_general.vc_tta.vc_tta-tabs .vc_tta-tabs-list .vc_tta-tab a").css("text-transform", "");
        }
    });
});

//Quotes
wp.customize("quote_typography[font-weight]", function(e) {
    $currentVal = $("blockquote").css("font-weight");
    e.bind(function(e) {
        if (e) {
            $("blockquote").css("font-weight", e);
        } else {
            $("blockquote").css("font-weight", "");
        }
    });
});
wp.customize("quote_typography[font-style]", function(e) {
    $currentVal = $("blockquote").css("font-style");
    e.bind(function(e) {
        if (e) {
            $("blockquote").css("font-style", e);
        } else {
            $("blockquote").css("font-style", "");
        }
    });
});
wp.customize("quote_typography[font-size]", function(e) {
    $currentVal = $("blockquote").css("font-size");
    e.bind(function(e) {
        if (e) {
            $("blockquote").css("font-size", parseInt(e, 10) + "px");
        } else {
            $("blockquote").css("font-size", "");
        }
    });
});
wp.customize("quote_typography[color]", function(e) {
    $currentVal = $("blockquote").css("color");
    e.bind(function(e) {
        if (e) {
            $("blockquote").css("color", e);
        } else {
            $("blockquote").css("color", "");
        }
    });
});
wp.customize("quote_typography[line-height]", function(e) {
    $currentVal = $("blockquote").css("line-height");
    e.bind(function(e) {
        if (e) {
            $("blockquote").css("line-height", e);
        } else {
            $("blockquote").css("line-height", "");
        }
    });
});
wp.customize("quote_typography[letter-spacing]", function(e) {
    $currentVal = $("blockquote").css("letter-spacing");
    e.bind(function(e) {
        if (e) {
            $("blockquote").css("letter-spacing", parseInt(e, 10) + "px");
        } else {
            $("blockquote").css("letter-spacing", "");
        }
    });
});
wp.customize("quote_typography[text-transform]", function(e) {
    $currentVal = $("blockquote").css("text-transform");
    e.bind(function(e) {
        if (e) {
            $("blockquote").css("text-transform", e);
        } else {
            $("blockquote").css("text-transform", "");
        }
    });
});
} )( jQuery );