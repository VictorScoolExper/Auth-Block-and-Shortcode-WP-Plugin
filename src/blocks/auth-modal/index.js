import { useState } from 'react';
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, ColorPalette } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js';
import './main.css';

registerBlockType('auth-block-shortcode/auth-modal', {
  icon: {
    src: icons.popup
  },
  edit({ attributes, setAttributes }) {
    const { showRegister, tabColor } = attributes;
    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={ __('General', 'auth-block-shortcode') }>
            <ToggleControl
                label={__('Show Register', 'auth-block-shortcode')}
                help={
                    showRegister ?
                    __('Showing registration form', 'auth-block-shortcode') : 
                    __('Hiding registration form', 'auth-block-shortcode')
                }
                checked={showRegister}
                onChange={showRegister => setAttributes({ showRegister })}
            />

            <div>
                <label htmlFor="tab-color-picker">{__('Tab Active Color', 'auth-block-shortcode')}</label>
                <ColorPalette
                    id="tab-color-picker"
                    value={tabColor}
                    onChange={(tabColor) => setAttributes({ tabColor })}
                />
            </div>
          </PanelBody>
        </InspectorControls>
        <div { ...blockProps }>
          {__('This block is not previewable from the editor. View your site for a live demo.', 'auth-block-shortcode')}
        </div>
      </>
    );
  }
});