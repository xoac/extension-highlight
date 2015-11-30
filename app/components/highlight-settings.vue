<template>


    <div class="uk-form uk-form-stacked">

        <h1>Highlight Settings</h1>

        <div class="uk-alert" v-if="status == 'loading'">
            Loading available styles...
        </div>

        <div class="uk-form-row">
            <label class="uk-form-label" for="input-style">Style</label>
            <div class="uk-form-controls">
                <select id="input-style" v-model="package.config.style">
                    <option v-for="option in styles" v-bind:value="option">
                        {{ option }}
                    </option>
                </select>
            </div>
        </div>

        <div class="uk-form-row">
            <label class="uk-form-label" for="input-enable-auto">Enable</label>
            <div class="uk-form-controls uk-form-controls-text">
                <input type="radio" id="input-enable-auto" name="input-enable" value="auto" v-model="package.config.enable">
                <label for="input-enable-auto">
                    Auto detect (every page with embedded code)
                </label>
                <br>
                <input type="radio" id="input-enable-select" name="input-enable" value="select" v-model="package.config.enable">
                <label for="input-enable-select">
                    Selected pages only
                </label>
            </div>
        </div>

        <div class="uk-form-row">
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
                status: '',
                styles: []
            };
        },

        ready: function () {
            this.load();
        },

        settings: true,

        methods: {

            load: function () {
                this.$set('status', 'loading');

                this.$http.get('admin/highlight/styles', function (styles) {
                    this.$set('styles', styles);
                    this.$set('status', '');
                }).error(function () {
                    this.$set('status', 'error');
                    this.$notify('Could not load available styles.');
                })
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
