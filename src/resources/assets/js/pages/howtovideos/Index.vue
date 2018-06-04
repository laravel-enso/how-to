<template>

    <div class="columns">
        <div class="column is-three-quarters">
            <div class="columns">
                <div class="column">
                    <a class="button is-info is-outlined"
                        v-if="!addVideoMode && !editVideoMode"
                        @click="addVideoMode = true">
                        <span>
                            {{ __('Add How To Video') }}
                        </span>
                        <span class="icon is-small">
                            <fa icon="plus"/>
                        </span>
                    </a>
                    <div class="field has-addons video-description animated fadeIn"
                        v-else>
                        <div class="control">
                            <input class="input"
                                type="text"
                                :placeholder="__('video name')"
                                v-model="video.name">
                        </div>
                        <div class="control is-expanded">
                            <input class="input"
                                type="text"
                                :placeholder="__('video description')"
                                v-model="video.description">
                        </div>
                        <div class="control animated fadeIn">
                            <file-uploader :url="uploadLink"
                                :params="video"
                                @upload-successful="reset(); getVideos()"
                                file-key="video"
                                v-if="addVideoMode">
                                <a class="button is-outlined"
                                    slot="upload-button"
                                    slot-scope="{ openFileBrowser }"
                                    :disabled="!video.name"
                                    @click="openFileBrowser">
                                    <span class="icon">
                                        <fa icon="upload"/>
                                    </span>
                                </a>
                            </file-uploader>
                            <a class="button is-outlined is-success"
                                @click="video = video; update()"
                                v-if="editVideoMode">
                                <span class="icon">
                                    <fa icon="check"/>
                                </span>
                            </a>
                        </div>
                        <div class="control animated fadeIn"
                            v-if="addVideoMode || editVideoMode">
                            <a class="button is-danger is-outlined"
                                @click="reset()">
                                <span class="icon">
                                    <fa icon="times"/>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns is-multiline">
                <div class="column is-half"
                    v-for="(vid, index) in filteredVideos"
                    :key="index">
                    <how-to-video :video="vid"
                        :tags="tags"
                        @start-tagging="video = vid; tagVideoMode = true"
                        @stop-tagging="video = vid; tagVideoMode = false; update()"
                        @delete="videos.splice(index, 1)"
                        @update="video = vid; update()"
                        @edit="video = vid; editVideoMode = true;"/>
                </div>
            </div>
        </div>
        <div class="column is-one-quarter">
            <div class="box">
                <div class="level">
                    <div class="level-left">
                        <div class="level-item has-margin-bottom-small">
                            <label class="label">
                                <span class="icon is-small">
                                    <fa icon="tags"
                                        size="xs"/>
                                </span>
                                {{ __('Tags') }}
                            </label>
                        </div>
                    </div>
                    <div class="level-right">
                        <div class="level-item">
                            <a class="button is-small is-outlined is-success"
                                v-if="query && tagIsNew"
                                @click="addTag">
                                <span class="icon is-small">
                                    <fa icon="check"/>
                                </span>
                            </a>
                            <a class="button is-small is-outlined is-danger"
                                v-if="!query && selectedTag"
                                @click="editTagMode = true">
                                <span class="icon is-small">
                                    <fa icon="pencil-alt"/>
                                </span>
                            </a>
                            <a class="button is-small is-outlined is-success has-margin-left-small"
                                v-if="editTagMode"
                                @click="editTagMode = false; updateTag()">
                                <span class="icon is-small">
                                    <fa icon="check"/>
                                </span>
                            </a>
                            <a class="button is-small is-outlined has-margin-left-small"
                                v-if="editTagMode"
                                @click="editTagMode = false">
                                <span class="icon is-small">
                                    <fa icon="times"/>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <input class="input"
                    type="text"
                    v-model="selectedTag.name"
                    v-if="editTagMode">
                <input class="input"
                    type="text"
                    v-model="query"
                    v-else>
                <div class="has-margin-top-medium">
                    <span :class="[
                        'tag has-margin-small is-clickable',
                         { 'is-warning' : tag.selected }
                    ]"
                        v-for="tag in filteredTags"
                        @click="
                            tagVideoMode
                                ? video.tagList.push(tag.id)
                                : tag.selected = !tag.selected
                        "
                        :key="tag.id">
                        <span class="has-margin-right-small">
                            {{ tag.name }}
                        </span>
                        <a class="delete is-small"
                            @click="deleteTag(tag.id)"
                            v-if="canAccess('howTo.tags.destroy')"/>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import fontawesome from '@fortawesome/fontawesome';
import { faPlus, faUpload, faTimes, faCheck, faPencilAlt, faTags } from '@fortawesome/fontawesome-free-solid/shakable.es';
import FileUploader from '../../components/enso/fileuploader/FileUploader.vue';
import HowToVideo from '../../components/enso/howtovideos/HowToVideo.vue';

fontawesome.library.add([faPlus, faUpload, faTimes, faCheck, faPencilAlt, faTags]);

export default {
    components: { FileUploader, HowToVideo },

    data() {
        return {
            videos: [],
            video: {
                name: null,
                description: null,
                tagList: [],
            },
            addVideoMode: false,
            editVideoMode: false,
            tagVideoMode: false,
            query: '',
            tags: [],
            editTagMode: false,
        };
    },

    computed: {
        uploadLink() {
            return route('howTo.videos.store');
        },
        filteredVideos() {
            return this.selectedTags.length === 0 || this.tagVideoMode
                ? this.videos
                : this.videos.filter(({ tagList }) =>
                    tagList.filter(tagId =>
                        this.selectedTags.findIndex(({ id }) =>
                            tagId === id) !== -1).length);
        },
        filteredTags() {
            return !this.query
                ? this.tags.filter(({ id }) => !this.video.tagList.includes(id))
                : this.tags.filter(({ name, id }) => !this.video.tagList.includes(id) &&
                    name.toLowerCase().indexOf(this.query.toLowerCase()) > -1);
        },
        tagIsNew() {
            return !!this.query && this.tags.findIndex(({ name }) =>
                name.toLowerCase() === this.query.toLowerCase()) === -1;
        },
        selectedTags() {
            return this.tags.filter(({ selected }) => selected);
        },
        selectedTag() {
            return this.selectedTags.length === 1 && this.selectedTags[0];
        },
    },

    created() {
        this.getVideos();
        this.getTags();
    },

    methods: {
        getVideos() {
            axios.get(route('howTo.videos.index'))
                .then(({ data }) => (this.videos = data))
                .catch(error => this.handleError(error));
        },
        getTags() {
            axios.get(route('howTo.tags.index'))
                .then(({ data }) => (this.tags = data))
                .catch(error => this.handleError(error));
        },
        reset() {
            this.video = {
                name: null,
                description: null,
                tagList: [],
            };

            this.addVideoMode = false;
            this.editVideoMode = false;
            this.tagVideoMode = false;
            this.editTagMode = false;
        },
        tagVideo(tagMode) {
            if (!tagMode) {
                this.video.tagList.push(...this.selectedTags);
                this.update();
            }

            this.deselectTags();
        },
        deselectTags() {
            this.tags.map((tag) => {
                tag.selected = false;
                return tag;
            });
        },
        addTag() {
            axios.post(route('howTo.tags.store'), { name: this.query })
                .then(({ data }) => {
                    this.tags.push(data);
                    this.query = '';
                }).catch(error => this.handleError(error));
        },
        updateTag() {
            axios.patch(route('howTo.tags.update', this.selectedTag.id), {
                name: this.selectedTag.name,
            }).catch(error => this.handleError(error));
        },
        deleteTag(tagId) {
            axios.delete(route('howTo.tags.destroy', tagId))
                .then(() => {
                    const index = this.tags.findIndex(({ id }) => id === tagId);
                    this.tags.splice(index, 1);
                }).catch(error => this.handleError(error));
        },
        update() {
            axios.patch(route('howTo.videos.update', this.video.id), this.video)
                .then(({ data }) => {
                    this.$toastr.success(data.message);
                    this.reset();
                }).catch(error => this.handleError(error));
        },
    },
};

</script>
