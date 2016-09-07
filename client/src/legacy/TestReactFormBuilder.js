import jQuery from 'jQuery';
import i18n from 'i18n';
import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import FormBuilder from 'components/FormBuilder/FormBuilder';

jQuery.entwine('ss', ($) => {
    /**
     * Kick off Test React FormBuilder admin section.
     * Uses React to rebuild the list of fields from FrameworkTest's TestPages.
     */
    $('.cms-content.TestReactFormBuilder').entwine({
        onmatch() {
            setTimeout(() => this._renderForm(), 100);
        },

        onunmatch() {
            this._clearForm();
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
                .config.sections['TestReactFormBuilder'];
            const schemaUrl = sectionConfig.form.TestEditForm.schemaUrl;

            ReactDOM.render(
                <Provider store={store}>
                    <FormBuilder
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

    $('.cms-content.TestReactFormBuilder .nav-link').entwine({
       onclick: function (e) {
           // this is required because the React version of e.preventDefault() doesn't work
           // this is to stop React Tabs from navigating the page
           e.preventDefault();
       }
    });
});
