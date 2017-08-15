import jQuery from 'jQuery';
import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import FormBuilderLoader from 'containers/FormBuilderLoader/FormBuilderLoader';
import { provideInjector } from 'lib/Injector';

const sectionConfigKey = 'TestReactFormBuilder';
const InjectedFormBuilderLoader = provideInjector(FormBuilderLoader);
jQuery.entwine('ss', ($) => {
  /**
   * Kick off Test React FormBuilder admin section.
   * Uses React to rebuild the list of fields from FrameworkTest's TestPages.
   */
  $('.TestReactFormBuilder').entwine({
    onmatch() {
      setTimeout(() => this._renderForm(), 100);
      // need to force scrollable .css() doesn't work with important which is needed for this case
      this[0].style.setProperty('overflow-y', 'scroll', 'important');
    },

    onunmatch() {
      this._clearForm();
      this.css('overflow-y', false);
    },

    open() {
      this._renderForm();
    },

    close() {
      this._clearForm();
    },

    _renderForm() {
      const store = window.ss.store;
      const sectionConfig = store.getState()
        .config.sections.find((section) => section.name === sectionConfigKey);
      const schemaUrl = sectionConfig.form.TestEditForm.schemaUrl;

      ReactDOM.render(
        <Provider store={store}>
          <InjectedFormBuilderLoader
            identifier="TestReactForm"
            schemaUrl={schemaUrl}
            handleSubmit={(...args) => this._handleSubmit(...args)}
          />
        </Provider>,
        this[0]
      );
    },

    _clearForm() {
      ReactDOM.unmountComponentAtNode(this[0]);
      // this.empty();
    },

    _handleSubmit(event, fieldValues, submitFn) {
      event.preventDefault();

      return submitFn();
    },

  });

  $('.TestReactFormBuilder .nav-link').entwine({
    onclick: function (e) {
      // this is required because the React version of e.preventDefault() doesn't work
      // this is to stop React Tabs from navigating the page
      e.preventDefault();
    }
  });
});
