<template>
    <div>
    	<div v-show="state === 'default'">
	    	<div class="tw-flex tw-justify-between tw-mb-1">
	    		<p class="tw-leading-normal tw-text-grey-darkest tw-text-lg">{{ comment.body }}</p>
	    		<button class="btn btn-primary btn-sm" type="button" v-if="editable" @click="state = 'editing'">Edit</button>
	    	</div>
	    	<div class="tw-text-grey-dark tw-leading-normal tw-text-sm">
	    		<p>{{ comment.author.name }} <span class="tw-mx-1 tw-text-xs">•</span> {{ comment.created_at}} </p>
	    	</div>
    	</div>
    	<div v-show="state === 'editing'">
            <div class="tw-mb-3">
		        <h3 class="tw-text-black tw-text-xl">Update Comment</h3>
		    </div>
            <textarea v-model="data.body" placeholder="Update comment" class="comment-input tw-h-24"></textarea>
            <div class="md:tw-flex-row tw-flex tw-flex-col tw-items-center tw-mt-2">
                <button class="btn btn-success btn-sm md:tw-mr-1 sm:tw-w-full sm:tw-mb-1" @click="saveEdit">Update</button>
                <button class="btn btn-warning btn-sm text-white md:tw-mr-1 sm:tw-w-full sm:tw-mb-1 " @click="resetEdit">Cancel</button>
                <button class="btn btn-danger btn-sm md:tw-mr-1 sm:tw-w-full sm:tw-mb-1" @click="deleteComment">Delete</button>
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