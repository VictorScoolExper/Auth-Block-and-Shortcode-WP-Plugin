import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, CheckboxControl, TextControl, ColorPalette } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import icons from '../../icons.js'
import './main.css'

registerBlockType('auth-block-shortcode/header-tools', {
  icon: {
    src: icons.person
  },
  edit({ attributes, setAttributes }) {
    const { showAuth, signedInRedirectLink, textandIconColor } = attributes;

    const blockProps = useBlockProps();

    return (
      <>
        <InspectorControls>
          <PanelBody title={ __('General', 'auth-block-shortcode') }>
            <SelectControl
              label={__('Show Login/Register link', 'auth-block-shortcode')}
              value={showAuth}
              options={[
                { label: __('No', 'auth-block-shortcode'), value: false },
                { label: __('Yes', 'auth-block-shortcode'), value: true }
              ]}
              onChange={newVal => setAttributes({showAuth: (newVal === "true")})}
            />
            
            <CheckboxControl
              label={__('Show Login/Register Link', 'auth-block-shortcode')}
              help={
                showAuth ?
                __('Showing Link', 'auth-block-shortcode') :
                __('Hiding Link', 'auth-block-shortcode')
              }
              checked={showAuth}
              onChange={showAuth => setAttributes({ showAuth })}
            />

            <TextControl
              label={__('Logged In Redirect Link', 'auth-block-shortcode')}
              value={ signedInRedirectLink }
              onChange={ signedInRedirectLink => setAttributes({ signedInRedirectLink })}
            />

            <div>
                <label htmlFor="tab-color-picker">{__('Icon and Text Color', 'auth-block-shortcode')}</label>
                <ColorPalette
                    id="tab-color-picker"
                    value={textandIconColor}
                    onChange={(textandIconColor) => setAttributes({ textandIconColor })}
                />
            </div>
          </PanelBody>
        </InspectorControls>
        <div { ...blockProps }>
          { 
            showAuth ?
            <a 
              className="signin-link open-modal" 
              href="#"
              style={{color: textandIconColor }}
              >
              <div className="signin-icon">
                <i className="bi bi-person-circle"></i>
              </div>
              <div className="signin-text">
                <small style={{color: '#000000'}}>Hello, Sign in</small>
                My Account
              </div>
            </a> : 
            null
          }
        </div>
      </>
    );
  }
});