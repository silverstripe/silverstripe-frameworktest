/* global window */
import jQuery from 'jquery';
import React from 'react';
import { createRoot } from 'react-dom/client';
import { Provider } from 'react-redux';
import { provideInjector } from 'lib/Injector';
import FormBuilderLoader from 'containers/FormBuilderLoader/FormBuilderLoader';

const sectionConfigKey = 'TestReactFormBuilder';
const InjectedFormBuilderLoader = provideInjector(FormBuilderLoader);

jQuery.entwine('ss', ($) => {
  /**
   * Kick off Test React FormBuilder admin section.
   * Uses React to rebuild the list of fields from FrameworkTest's TestPages.
   */
  $('.js-injector-boot .TestReactFormBuilder').entwine({
    ReactRoot: null,

    onmatch() {
      this._renderForm();
    },

    onunmatch() {
      this._clearForm();
    },

    container() {
      let container = this.find('.frameworktest-react-container');

      if (!container.length) {
        container = $('<div class="frameworktest-react-container panel panel--padded" style="overflow-y: auto; max-height: 100%;"></div>');
        this.append(container);
      }

      container.siblings('form').hide();

      return container[0];
    },

    _renderForm() {
      const { store } = window.ss;
      const sectionConfig = store.getState()
        .config.sections.find((section) => section.name === sectionConfigKey);
      const { schemaUrl } = sectionConfig.form.TestEditForm;

      const root = createRoot(this.container());
      root.render(
        <Provider store={store}>
          <InjectedFormBuilderLoader
            schemaUrl={schemaUrl}
            handleSubmit={(...args) => this._handleSubmit(...args)}
            identifier="FrameworkTest.ReactSection"
          />
        </Provider>,
      );
      this.setReactRoot(root);
    },

    _clearForm() {
      const root = this.getReactRoot();
      if (root) {
        root.unmount();
        this.setReactRoot(null);
      }
      // this.empty();
    },

    _handleSubmit(event, fieldValues, submitFn) {
      event.preventDefault();

      // eslint-disable-next-line no-console
      console.log(fieldValues);

      return submitFn();
    },

  });

  $('.TestReactFormBuilder .nav-link').entwine({
    onclick(e) {
      // this is required because the React version of e.preventDefault() doesn't work
      // this is to stop React Tabs from navigating the page
      e.preventDefault();
    },
  });
});
