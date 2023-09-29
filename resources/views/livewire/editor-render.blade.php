<div class="modal fade" id="EditorRender" tabindex="-1" role="dialog" data-mdb-backdrop="static" aria-labelledby="updater"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl cascading-modal" style="margin-top: 4%" wire:ignore.self>

        <style>
            .contentModel {
                min-height: 300px;
                max-height: 600px;
                overflow-y: scroll;
                overflow-x: hidden;
                border: none;
                background-color: transparent;
                padding: 10px;
                font-size: 1rem;
                line-height: 1.5;
                color: #212529;
                background-clip: padding-box;
                box-shadow: inset 0 0 0 transparent;
                border-radius: .25rem;
                transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            }
        </style>


        <!-- Body -->

        <div class="modal-content" wire:ignore.self>
            <div class="modal-c-tabs" wire:ignore.self>
                <ul class="nav md-tabs tabs-2 bg-color-green" role="tablist" wire:ignore.self>

                    @if ($description)
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#descriptionModel" role="tab">
                                <i class="fas fa-book-open-reader"></i>
                                {{ __('Description') }}
                            </a>
                        </li>
                    @endif

                    @if ($other_info)
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#otherInfoModel" role="tab">
                                <i class="fas fa-book-open-reader"></i>
                                {{ __('Other Info') }}
                            </a>
                        </li>
                    @endif

                </ul>

                <div class="tab-content" wire:ignore.self>

                    @if ($description)
                        <div class="tab-pane fade in show active" id="descriptionModel" role="tabpanel">
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <label class="form-label select-label mb-1"><strong>Description</strong></label>
                                    <div class="col-md-12 form-group editorRenderDescription contentModel">

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($other_info)
                        <div class="tab-pane fade in" id="otherInfoModel" role="tabpanel">
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <label class="form-label select-label mb-1"><strong>Other Info</strong></label>
                                    <div class="col-md-12 form-group editorRenderOtherInfo contentModel">
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button class="btn text-white button-hover-black bg-color-green" data-mdb-dismiss="modal">
                    {{ __('Close') }}
                </button>
            </div>
        </div>

    </div>

    @push('editor-render')
        <script>
            $(document).ready(function() {

                window.livewire.on('editorRenderDescription', (html) => {
                    $('.editorRenderDescription').html(html);
                });

                window.livewire.on('editorRenderOtherInfo', (html) => {
                    $('.editorRenderOtherInfo').html(html);
                });

            });
        </script>
    @endpush
</div>
