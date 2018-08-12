<template>
    <div class="tw-max-w-3xl mx-auto">
		 <div class="tw-bg-white tw-rounded tw-shadow tw-p-8 tw-my-4">
            <div class="tw-mb-4">
                <h2 class="tw-text-black">Comments</h2>
            </div>
            <textarea 
            	v-model="data.body" 
            	placeholder="Add a comment" 
            	class="comment-input"
            	:class="[state === 'editing' ? 'tw-h-24' : 'tw-h-10']"
            	@focus="startEditing"></textarea>
            <div v-show="state === 'editing'" class="tw-mt-3">
                <button class="btn btn-success btn-sm" @click="saveComment">Save</button>
                <button class="btn btn-warning btn-sm text-white" @click="stopEditing()">Cancel</button>
            </div>
        </div>
    	<div class="tw-bg-white tw-rounded tw-shadow tw-p-8 tw-my-4">
    		<comment 
    			v-for="(comment, index) in comments" 
    			:key="comment.id" 
    			:comment="comment" 
    			:user="user" 
    			:class="[index === comments.length - 1 ? '' : 'tw-mb-6']"
    			@comment-updated="updateComment($event)"
    			@comment-deleted="deleteComment($event)"></comment>
    	</div>
    </div>
</template>

<script>
	import comment from './CommentItem';

    export default {
    	props: {
		    user: {
		        required: true,
		        type: Object,
		    },
		    post: {
		        required: true,
		        type: Number,
		    },
		},
    	components: {
    		comment,
    	},
        data () {
            return {
            	comments: [],
	        	state: 'default',
	        	data: {
	        		body: '',
	        	}
          	}
        },
        computed: {
        	endpoint () {
        		return `/posts/${this.post}/comments`;
        	},
        },
        mounted() {
        	this.fetchComments();
        },
        methods: {
        	fetchComments() {
			    axios.get(this.endpoint)
			        .then(({data}) => {
			            this.comments = data;
			        })
			},
        	startEditing() {
		        this.state = 'editing';
		    },
		    stopEditing() {
		        this.state = 'default';
		        this.data.body = '';
		    },
        	saveComment() {
			    axios.post(this.endpoint, this.data)
			        .then(({data}) => {
			            this.comments.unshift(data);
			            this.stopEditing();
			        });
			},
			commentIndex(commentId) {
			    return this.comments.findIndex((element) => {
			        return element.id === commentId;
			    });
			},
		    updateComment($event) {
		        axios.put(`${this.endpoint}/${$event.id}`, $event)
		        	.then(({data}) => {
			           this.comments[this.commentIndex($event.id)].body = data.body;
			        });
		    },
		    deleteComment($event) {
		        axios.delete(`${this.endpoint}/${$event.id}`, $event)
		        	.then(() => {
			    		this.comments.splice(this.commentIndex($event.id), 1);
			        });

			},
		},
    }
</script>