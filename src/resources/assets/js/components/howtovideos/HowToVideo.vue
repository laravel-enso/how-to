<template>

    <card icon="video"
        :title="video.name"
        :controls="4">
        <card-control slot="control-1"
            v-if="!video.poster_saved_name && canAccess('howTo.posters.store')">
            <file-uploader :url="uploadLink"
                :params="{ videoId: video.id }"
                file-key="poster"
                @upload-successful="video.poster_saved_name = $event.saved_name">
                <span class="icon"
                    slot="upload-button"
                    slot-scope="{ openFileBrowser }"
                    @click="openFileBrowser">
                        <fa :icon="['far', 'image']"/>
                </span>
            </file-uploader>
        </card-control>
        <card-control slot="control-2">
            <v-popover trigger="hover">
                <span class="icon"
                    @click="$emit('edit')"
                    v-if="canAccess('howTo.videos.update')">
                    <fa :icon="['far', 'edit']"/>
                </span>
                <span class="icon"
                     v-else>
                    <fa :icon="info"/>
                </span>
                <template slot="popover">
                    <label class="label">{{ __('Description') }}</label>
                    <p>{{ video.description }}</p>
                </template>
            </v-popover>
        </card-control>
        <card-control slot="control-3"
            v-if="canAccess('howTo.videos.update')">
            <v-popover trigger="hover">
                <span class="icon"
                    @click="tagMode = !tagMode; $emit(tagMode ? 'start-tagging' : 'stop-tagging')">
                    <fa :icon="tagMode ? 'check' : 'tags'"/>
                </span>
                <template slot="popover">
                    <p>{{ __('Add tags') }}</p>
                </template>
            </v-popover>
        </card-control>
        <card-control slot="control-4"
            v-if="video.poster_saved_name">
            <popover v-if="canAccess('howTo.posters.destroy')"
                @confirm="destroyPoster">
                <span class="icon is-small">
                    <fa :icon="['far', 'trash-alt']"/>
                </span>
            </popover>
        </card-control>
        <card-control slot="control-4"
            v-else>
            <popover v-if="canAccess('howTo.videos.destroy')"
                @confirm="destroyVideo">
                <span class="icon is-small">
                    <fa :icon="['far', 'trash-alt']"/>
                </span>
            </popover>
        </card-control>
        <video-player :options="options()"
            class="vjs-custom-skin"
            playsinline/>
        <div slot="footer"
            class="card-footer">
            <div class="card-footer-item">
                <span class="tag"
                    v-if="!video.tagList.length">
                    {{ __('untagged') }}
                </span>
                <span class="tag has-margin-right-small"
                    v-for="(tag, index) in tagList"
                    :key="index"
                    v-else>
                    <span class="has-margin-right-small">
                        {{ tag.name }}
                    </span>
                    <a class="delete is-small"
                        @click="removeTag(tag)"
                        v-if="canAccess('howTo.videos.update')"/>
                </span>
            </div>
        </div>
    </card>
</template>

<script>

import { VTooltip, VPopover } from 'v-tooltip';
import { videoPlayer } from 'vue-video-player';
import 'video.js/dist/video-js.css';
import 'vue-video-player/src/custom-theme.css';
import fontawesome from '@fortawesome/fontawesome';
import { faInfo, faTags } from '@fortawesome/fontawesome-free-solid/shakable.es';
import { faTrashAlt, faEdit, faImage } from '@fortawesome/fontawesome-free-regular/shakable.es';
import Card from '../bulma/Card.vue';
import CardControl from '../bulma/CardControl.vue';
import Popover from '../bulma/Popover.vue';
import FileUploader from '../fileuploader/FileUploader.vue';

fontawesome.library.add([faTrashAlt, faInfo, faTags, faEdit, faImage]);

export default {
    name: 'HowToVideo',

    directives: { tooltip: VTooltip },

    components: {
        Card, CardControl, Popover, videoPlayer, VPopover, FileUploader,
    },

    props: {
        video: {
            type: Object,
            required: true,
        },
        tags: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            edit: false,
            tagMode: false,
        };
    },

    computed: {
        uploadLink() {
            return route('howTo.posters.store');
        },
        tagList() {
            return this.tags.filter(({ id }) =>
                this.video.tagList.includes(id));
        },
    },

    methods: {
        options() {
            return {
                muted: false,
                language: 'en',
                playbackRates: [0.7, 1.0, 1.5, 2.0],
                aspectRatio: '16:9',
                sources: [{
                    type: 'video/mp4',
                    src: route('howTo.videos.show', this.video.id),
                }],
                poster: this.video.poster_saved_name
                    ? route('howTo.posters.show', this.video.id)
                    : '',
            };
        },
        destroyPoster() {
            axios.delete(route('howTo.posters.destroy', this.video.id))
                .then(({ data }) => {
                    this.$toastr.success(data.message);
                    this.video.poster_saved_name = null;
                }).catch(error => this.handleError(error));
        },
        destroyVideo() {
            axios.delete(route('howTo.videos.destroy', this.video.id))
                .then(({ data }) => {
                    this.$toastr.success(data.message);
                    this.$emit('delete');
                }).catch(error => this.handleError(error));
        },
        removeTag(tag) {
            const index = this.video.tagList.findIndex(({ id }) => id === tag.id);
            this.video.tagList.splice(index, 1);
            this.$emit('update');
        },
    },
};

</script>

<style lang="scss" scoped>

    .tooltip-inner.popover-inner {
        .label {
            color: #f9f9f9;
        }
    }

    .card-footer {
        white-space: nowrap;
        overflow: scroll;
        text-overflow: ellipsis;
    }

</style>
