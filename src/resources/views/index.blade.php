@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("How To Videos"))

@section('content')

    <page v-cloak>
        <span slot="header" style="display:flex">
            <button class="btn btn-success"
                @click="addVideoMode=true"
                v-if="!addVideoMode">
                {{ __('Add How To') }}
                <i class="fa fa-plus"></i>
            </button>
            <span v-if="addVideoMode" style="display:inline-flex">
                <input type="text"
                    class="margin-right-md"
                    v-model="description"
                    v-focus
                    placeholder="{{ __('Add a description for the how to video') }}"
                    size="100">
                <file-uploader v-if="description"
                    @upload-successful="addVideo"
                    @upload-error="reportError"
                    :params="{ description: description }"
                    url="/howToVideos">
                    <span slot="upload-button">
                        <button class="btn btn-sm btn-success">
                            {{ __('Upload file') }}
                            <i class="fa fa-upload"></i>
                        </button>
                    </span>
                </file-uploader>
                <button class="btn btn-sm btn-danger margin-left-md" @click="addVideoMode=false">X</button>
            </span>
        </span>
        <div class="col-md-9">
            <div class="text-center"
                v-if="!videos.length">
                <h5>{{ __('There are no uploaded videos yet') }}</h5>
            </div>
            <div class="text-center"
                v-if="!filteredVideos.length && this.videos.length">
                <h5>{{ __('There are no videos that match the selected tag(s)') }}</h5>
            </div>
            <div class="col-md-6"
                v-for="video in filteredVideos">
                <how-to-video :video="video"
                    :tag-list="tagSelectList"
                    @update-video="updateVideo(video)"
                    @add-poster="addPoster($event, video)"
                    @delete-poster="deletePoster($event, video)"
                    @delete-video="deleteVideo(video.id)">
                </how-to-video>
            </div>
        </div>
        <div class="col-md-3">
            <box theme="primary"
                title="{{ __('Tag List') }}"
                icon="fa fa-tags"
                border open
                refresh search
                :overlay="loadingTags"
                @refresh="getTags"
                @query-update="tag=$event"
                :badge="tagList.length"
                ref="tagsBox">
                <span slot="btn-box-tool"
                    v-if="tagIsNew">
                    <button class="btn btn-xs btn-success"
                        @click="addTag">
                        {{ __('Add') }}
                        <i class="fa fa-plus"></i>
                    </button>
                </span>
                <div v-if="!filteredTags.length" class="text-center">
                    {{ __('no tags are defined yet') }}
                </div>
                <ul style="list-style: none; padding-left:5px">
                    <li v-for="tag in filteredTags"
                        class="margin-bottom-xs">
                        <input type="checkbox" :value="tag.id" v-model="tags">
                        <span v-if="editedTag !== tag.id">
                            <i class="btn btn-xs btn-warning fa fa-pencil-square-o"
                                @click="editedTag=tag.id">
                            </i>
                            <i class="btn btn-xs btn-danger fa fa-trash margin-left-xs"
                                @click="deleteTag(tag)">
                            </i>
                            <span class="margin-left-md">
                                @{{ tag.name }}
                            </span>
                        </span>
                        <span v-else>
                            <i class="btn btn-xs btn-danger fa fa-times" @click="editedTag = null"></i>&nbsp;
                            <i class="btn btn-xs btn-success fa fa-check" @click="updateTag(tag)"></i>&nbsp;
                            <input type="text" class="margin-left-md"
                                v-focus
                                v-model="tag.name"
                                @keypress.enter="updateTag(tag)">
                        </span>
                    </li>
                </ul>
            </box>
            </div>
        </div>
    </page>

@endsection

@push('scripts')

    <script>
        const vm = new Vue({
            el: '#app',

            data: {
                tagList: [],
                tags: [],
                tag: null,
                loadingTags: false,
                editedTag: null,
                addVideoMode: false,
                description: null,
                videos: {!! $videos !!}
            },

            computed: {
                filteredVideos() {
                    return this.tags.length === 0
                        ? this.videos
                        : this.videos.filter(video => video.tagList.filter(tag => this.tags.includes(tag)).length);
                },
                filteredTags() {
                    return this.tag
                    ? this.tagList.filter(tag => {
                        return tag.name.toLowerCase().indexOf(this.tag.toLowerCase()) > -1;
                    })
                    : this.tagList;
                },
                tagSelectList() {
                    return this.tagList.reduce((obj, {id, name}) => {
                        obj[id] = name;
                        return obj
                    }, {});
                },
                tagIsNew() {
                    return this.tag && !this.filteredTags.pluck('name').includes(this.tag);
                }
            },

            methods: {
                getTags() {
                    this.loadingTags = true;

                    axios.get('/howToTags').then(response => {
                        this.tagList = response.data;
                        this.loadingTags = false;
                    }).catch(error => {
                        this.loadingTags = false;
                        this.reportEnsoException(error);
                    });
                },
                addTag() {
                    this.loadingTags = true;
                    this.$refs.tagsBox.clearQuery();

                    axios.post('/howToTags', { name: this.tag }).then(response => {
                        this.tagList.push(response.data.tag);
                        toastr.success(response.data.message);
                        this.loadingTags = false;
                        this.tag = null;
                    }).catch(error => {
                        this.loadingTags = false;
                        this.tag = null;
                        this.reportEnsoException(error);
                    });
                },
                updateTag(tag) {
                    this.loadingTags = true;

                    axios.patch('/howToTags/' + tag.id, tag).then(response => {
                        toastr.success(response.data.message);
                        this.loadingTags = false;
                        this.editedTag = null;
                    }).catch(error => {
                        this.loadingTags = false;
                        this.reportEnsoException(error);
                    });
                },
                deleteTag(tag) {
                    this.loadingTags = true;

                    axios.delete('/howToTags/' + tag.id, tag).then(response => {
                        let index = this.tagList.findIndex(el => el.id === tag.id);
                        this.tagList.splice(index, 1);
                        toastr.success(response.data.message);
                        this.loadingTags = false;
                    }).catch(error => {
                        this.reportEnsoException(error);
                    });
                },
                addVideo(response) {
                    toastr.success(response.message);
                    this.videos.push(response.video);
                    this.description = null;
                    this.addVideoMode = false;
                },
                updateVideo(video) {

                    axios.patch('/howToVideos/' + video.id, video).then(response => {
                        toastr.success(response.data.message);
                    }).catch(error => {
                        this.reportEnsoException(error);
                    });
                },
                addPoster(event, video) {
                    video.poster_original_name = event.video.poster_original_name;
                    video.poster_saved_name = event.video.poster_saved_name;
                    toastr.success(event.message);
                },
                deletePoster(event, video) {
                    axios.delete('/howToPosters/' + video.id).then(response => {
                        video.poster_original_name = null;
                        video.poster_saved_name = null;
                        toastr.success(response.data.message);
                    }).catch(error => {
                        this.reportEnsoException(error);
                    });
                },
                deleteVideo(id) {
                    axios.delete('/howToVideos/' + id).then(response => {
                        let index = this.videos.findIndex(video => video.id === id);
                        this.videos.splice(index, 1);
                        toastr.success(response.data.message);
                    }).catch(error => {
                        this.reportEnsoException(error);
                    });
                },
                reportError() {
                    toastr.error('{{ __("Supported file formats: avi / mpeg / quicktime") }}');
                },
            },

            mounted() {
               this.getTags();
            }
        });
    </script>

@endpush