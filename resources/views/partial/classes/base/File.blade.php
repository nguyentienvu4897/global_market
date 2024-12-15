<script>
    class File extends BaseChildClass {
        no_set = [];
        constructor(form, parent) {
            super(form, parent);
        }

        before(form) {
            this.pre = randomString(20);
            this.id = '';
        }

        after(form) {
            let self = this;
            $(document).on('change', `#${this.element_id}`, function (e) {
                let filename = e.target.files[0].name;
                self.name = filename;
                if (self.parent.scope) self.parent.scope.$apply();
            })
        }

        get element_id() {
            return this.pre + '-' + this.id;
        }

        get file() {
            if (!$(`#${this.element_id}`).get(0)) return null;
            return $(`#${this.element_id}`).get(0).files[0];
        }

        get submit_data() {
            return this.file;
        }
    }
</script>
