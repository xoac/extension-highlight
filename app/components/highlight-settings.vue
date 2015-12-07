<template>

    <div class="uk-form uk-form-horizontal">

        <h1>Highlight Settings</h1>

        <div class="uk-form-row">
            <label class="uk-form-label" for="input-style">Style</label>
            <div class="uk-form-controls">
                <select id="input-style" v-model="package.config.style">
                    <option v-for="option in styles" :value="option">
                        {{ option }}
                    </option>
                </select>
            </div>
        </div>

        <hr>

        <div class="uk-form" v-if="package.config.enable=='select'">
            <label class="uk-form-label">Pages</label>
            <div class="uk-form-controls">
                <input-tree :active.sync="package.config.nodes"></input-tree>
            </div>
        </div>

        <hr>

        <div class="uk-form-row">
            <label class="uk-form-label" for="input-enable-auto">Auto detect</label>
            <div class="uk-form-controls uk-form-controls-text">
                <input type="checkbox" id="input-enable-auto" name="input-enable-auto" value="auto" v-model="package.config.autodetect">
                <label for="input-enable-auto">
                    Only load when code found on page
                </label>
            </div>
        </div>

        <hr>

        <div class="uk-form-row uk-margin-top">
            <div class="uk-form-controls">
                <button class="uk-button uk-button-primary" @click.prevent="save">Save</button>
            </div>
        </div>

    </div>

</template>

<script>

    module.exports = {

        props: ['package'],

        data: function() {
            return {
                styles: []
            };
        },

        ready: function () {
            this.load();
        },

        settings: true,

        methods: {

            load: function () {
                this.$http.get('admin/highlight/config', function (data) {
                    this.$set('styles', data.styles);
                }).error(function () {
                    this.$notify('Could not load styles.');
                });
            },

            save: function () {
               this.$http.post('admin/system/settings/config', {
                   name: 'highlight',
                   config: this.package.config
               }, function () {
                   this.$notify('Settings saved.', '');
               }).error(function (data) {
                   this.$notify(data, 'danger');
               }).always(function () {
                   this.$parent.close();
               });
           }
       }
    };

    window.Extensions.components['highlight-settings'] = module.exports;
</script>
