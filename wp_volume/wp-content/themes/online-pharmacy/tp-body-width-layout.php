<?php

	$online_pharmacy_tp_theme_css = "";

	$online_pharmacy_theme_lay = get_theme_mod( 'online_pharmacy_tp_body_layout_settings','Full');
    if($online_pharmacy_theme_lay == 'Container'){
		$online_pharmacy_tp_theme_css .='body{';
			$online_pharmacy_tp_theme_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$online_pharmacy_tp_theme_css .='}';
		$online_pharmacy_tp_theme_css .='.page-template-front-page .menubar{';
			$online_pharmacy_tp_theme_css .='position: static;';
		$online_pharmacy_tp_theme_css .='}';
		$online_pharmacy_tp_theme_css .='.scrolled{';
			$online_pharmacy_tp_theme_css .='width: auto; left:0; right:0;';
		$online_pharmacy_tp_theme_css .='}';
	}else if($online_pharmacy_theme_lay == 'Container Fluid'){
		$online_pharmacy_tp_theme_css .='body{';
			$online_pharmacy_tp_theme_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$online_pharmacy_tp_theme_css .='}';
		$online_pharmacy_tp_theme_css .='.page-template-front-page .menubar{';
			$online_pharmacy_tp_theme_css .='width: 99%';
		$online_pharmacy_tp_theme_css .='}';
		$online_pharmacy_tp_theme_css .='.scrolled{';
			$online_pharmacy_tp_theme_css .='width: auto; left:0; right:0;';
		$online_pharmacy_tp_theme_css .='}';
	}else if($online_pharmacy_theme_lay == 'Full'){
		$online_pharmacy_tp_theme_css .='body{';
			$online_pharmacy_tp_theme_css .='max-width: 100%;';
		$online_pharmacy_tp_theme_css .='}';
	}

    $online_pharmacy_scroll_position = get_theme_mod( 'online_pharmacy_scroll_top_position','Right');
    if($online_pharmacy_scroll_position == 'Right'){
        $online_pharmacy_tp_theme_css .='#return-to-top{';
            $online_pharmacy_tp_theme_css .='right: 20px;';
        $online_pharmacy_tp_theme_css .='}';
    }else if($online_pharmacy_scroll_position == 'Left'){
        $online_pharmacy_tp_theme_css .='#return-to-top{';
            $online_pharmacy_tp_theme_css .='left: 20px;';
        $online_pharmacy_tp_theme_css .='}';
    }else if($online_pharmacy_scroll_position == 'Center'){
        $online_pharmacy_tp_theme_css .='#return-to-top{';
            $online_pharmacy_tp_theme_css .='right: 50%;left: 50%;';
        $online_pharmacy_tp_theme_css .='}';
    }

		//Social icon Font size
		$online_pharmacy_social_icon_fontsize = get_theme_mod('online_pharmacy_social_icon_fontsize');
				$online_pharmacy_tp_theme_css .='.media-links i{';
		$online_pharmacy_tp_theme_css .='font-size: '.esc_attr($online_pharmacy_social_icon_fontsize).'px;';
				$online_pharmacy_tp_theme_css .='}';

		// site title and tagline font size option
		$online_pharmacy_site_title_font_size = get_theme_mod('online_pharmacy_site_title_font_size', 30);{
				$online_pharmacy_tp_theme_css .='.logo h1 a, .logo p a{';
		$online_pharmacy_tp_theme_css .='font-size: '.esc_attr($online_pharmacy_site_title_font_size).'px;';
				$online_pharmacy_tp_theme_css .='}';
		}

		$online_pharmacy_site_tagline_font_size = get_theme_mod('online_pharmacy_site_tagline_font_size', 15);{
				$online_pharmacy_tp_theme_css .='.logo p{';
		$online_pharmacy_tp_theme_css .='font-size: '.esc_attr($online_pharmacy_site_tagline_font_size).'px;';
				$online_pharmacy_tp_theme_css .='}';
		}
