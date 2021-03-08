require('./../../bootstrap');

import Vue from 'vue';

import Form from './../../plugins/form';

const app = new Vue({
    el: '#app',

    data: function() {
        return {
            form: new Form('register')
        }
    },
    methods: {
        onSubmit() {
          this.form.submit();
        }
    }
});