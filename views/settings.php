<div class="uk-form uk-form-horizontal" id="highlight">

    <h1>Highlight Settings</h1>

    <div class="uk-form-row">
        <label class="uk-form-label" for="input-style">Style</label>
        <div class="uk-form-controls">
            <select id="input-style" v-model="config.style">
                <option v-for="option in styles" v-bind:value="option">
                    {{ option }}
                </option>
            </select>
        </div>
    </div>

    <div class="uk-form-row">
        <label class="uk-form-label" for="input-enable-auto">Enable</label>
        <div class="uk-form-controls uk-form-controls-text">
            <input type="radio" id="input-enable-auto" name="input-enable" value="auto" v-model="config.enable">
            <label for="form-h-r">Auto detect (every page with embedded code)</label>
            <br>
            <input type="radio" id="input-enable-select" name="input-enable" value="select" v-model="config.enable">
            <label for="form-h-r1">Selected pages only</label>
        </div>
    </div>

    <div class="uk-form-row">
        <div class="uk-form-controls">
            <button class="uk-button uk-button-primary" @click.prevent="save">Save</button>
        </div>
    </div>


</div>

<script type="text/javascript">
    new Vue({
        el: '#highlight',
        data: window.$data,
        methods: {
            save: function() {
                var payload = {enable: this.config.enable, style: this.config.style};
                this.$http.post('admin/highlight/save', payload,
                    function() {
                        UIkit.notify('Saved.');
                    }).error(function() {
                        UIkit.notify('Oops, something went wrong.');
                    })
            }
        }
    })
</script>
