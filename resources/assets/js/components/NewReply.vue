<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea placeholder="Have something to say?" name="body" id="body" cols="30" rows="5"
                          class="form-control" v-model="body" required></textarea>
            </div>

            <button type="submit" class="btn btn-default" @click="addReply">Submit</button>
        </div>

        <p class="text-center" v-else>Please <a href="/login">sign in</a> to participate in the
            discussion.</p>
    </div>
</template>

<script>
    export default {
        props: ['endpoint'],

        data() {
            return {
                body: ''
            };
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        this.body = '';

                        flash('Your reply has been posted');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
