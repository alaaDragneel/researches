<template>
    <div>
    	<div v-show="state === 'default'">
	    	<div>
	    		<p>{{ comment.body }}</p>
	    		<button class="btn btn-primary btn-sm" type="button" v-if="editable" @click="state = 'editing'">Edit</button>
	    	</div>
	    	<div>
	    		<p>{{ comment.author.name }} <span>•</span> {{ comment.created_at}} </p>
	    	</div>
    	</div>
    	<div v-show="state === 'editing'">
            <div>
                <h3>Update Comment</h3>
            </div>
            <textarea v-model="data.body" placeholder="Update comment" class="border"></textarea>
            <div>
                <button class="btn btn-info btn-sm text-white" @click="saveEdit">Update</button>
                <button class="btn btn-warning btn-sm text-white" @click="resetEdit">Cancel</button>
                <button class="btn btn-danger btn-sm" @click="deleteComment">Delete</button>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
    	props: {
    		user: {
		        required: true,
		        type: Object,
		    },
    		comment: {
	    		required: true,
	    		type: Object,
    		},
    	},
        data: function() {
            return {
               	state: 'default',
		        data: {
		            body: this.comment.body,
		        },
          }
        },
        computed: {
        	editable() {
        		return this.user.id === this.comment.author.id;
        	}
        },
        methods: {
		  	saveEdit() {
			    this.state = 'default';
			    this.$emit('comment-updated', {
			        id: this.comment.id,
			        body: this.data.body,
			    });
			},
		    resetEdit() {
		        this.state = 'default';
		        this.data.body = this.comment.body;
		    },
		    deleteComment() {
			    this.$emit('comment-deleted', {
			        id: this.comment.id,
			    });
			}
		}
    }
</script>