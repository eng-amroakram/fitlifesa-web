<div class="modal fade" id="{{ $updater_id }}" tabindex="-1" role="dialog" data-mdb-backdrop="static"
    aria-labelledby="updater" aria-hidden="true" wire:ignore>
    <div class="modal-dialog {{ $size }} cascading-modal" style="margin-top: 4%">

        <div class="modal-content">

            <div class="modal-c-tabs">
                <x-updater.tabs :tabs="$tabs" :title="$title"></x-updater.tabs>

                <div class="tab-content">

                    <x-table.extensions.loading></x-table.extensions.loading>

                    @foreach ($contents as $content)
                        <x-updater.content :content="$content" :size="$size" :updaterbuttong="'submitUpdater'" :updaterid="$updater_id">
                        </x-updater.content>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

@push('updater')
    <script>
        $(document).ready(function() {

            //Buttons
            var $submitUpdater = $(".submitUpdater");

            //Inputs
            var $inputTextUpdater = $(".inputTextUpdater");
            var $inputSelectUpdater = $(".inputSelectUpdater");
            var $checkboxInputUpdater = $(".checkboxInputUpdater");

            //Next
            var $nextUpdater = $(".nextUpdater");


            var $data_updater = @json($data);

            function setInputUpdater($name, $value) {
                $data_updater[$name] = $value;
            }

            function getContentUpdater() {
                var $object = Object.assign({}, $data_updater);
                return JSON.stringify($object);
            }

            function numbers($name, $value) {

                if ($value) {

                    if (typeof $value == 'string') {
                        let string_number = $value.replace(/[^\d.]/g, "");

                        if (string_number.match(/\./g)) {
                            if (string_number.match(/\./g).length > 1) {
                                string_number = string_number.replace(/,/g, "").replace(/\.(?=.*\.)/g,
                                    "");
                            }
                        }

                        let number = parseFloat(string_number.replace(/,/g, ""));
                        return number;
                    }
                    return $value;
                }

            }

            $inputTextUpdater.on("input", function() {
                $name = $(this).attr("name");
                $value = $(this).val();
                setInputUpdater($name, $value);
            });

            $inputSelectUpdater.on("change", function() {
                $name = $(this).attr("name");
                $value = $(this).val();
                setInputUpdater($name, $value);
            });

            $checkboxInputUpdater.on('change', function() {
                let $value = $(this).val();
                let $name = $(this).attr('name');
                let $checked = $(this).is(':checked');

                if ($checked) {
                    $(this).prop('checked', true);
                    setInputUpdater($name, true);
                } else {
                    $(this).prop('checked', false);
                    setInputUpdater($name, false);
                }
            });

            $submitUpdater.on('click', function() {
                $(".reset-validation").text(" ");

                for (let key in $data_updater) {
                    if ($data_updater.hasOwnProperty(key)) {
                        if (key != "image" && key != "video") {
                            @this.set(key, $data_updater[key]);
                        }
                    }
                }

                Livewire.emit('update', getContentUpdater());

            });

            Livewire.on("updateError", function(errors) {
                $(".reset").text("");
                for (let key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        $("." + key + "-validation").text(errors[key]);
                    }
                }
            });

            Livewire.on("closeModal", function(check) {
                let $id = "#{{ $updater_id }}";
                $($id).modal('hide');
                $($id).removeClass('show');
                $($id).attr('aria-hidden', 'true');
                $($id).attr('aria-modal', 'false');
                $($id).css('display', 'none');
                $('body').removeClass('modal-open').css({
                    'overflow': '',
                    'padding-right': ''
                });
                // remove div of class modal-backdrop
                $('.modal-backdrop').remove();
                $(".reset-validation").val("");
                $data_updater = [];
            });

            Livewire.on('select2', function(id, value) {
                let $te = [value + ''];
                let convertedArray = $te.map(item => `'${item}'`);
                // Use join to join the elements into a string
                let result = '[' + convertedArray.join(', ') + ']';

                if ($te != 'null' && $te) {
                    let singleSelect = document.querySelector(id);
                    let singleSelectInstance = mdb.Select.getInstance(singleSelect);
                    singleSelectInstance.setValue($te);
                }
            });


            Livewire.on('setSelect2Multi', function(data, inputid, ids) {
                var $input = $("#" + inputid);
                var singleSelect = document.querySelector("#" + inputid);
                var singleSelectInstance = mdb.Select.getInstance(singleSelect);

                $input.empty();
                var array_ids = JSON.parse(ids);
                console.log(array_ids);

                $.each(data, function(index, value) {

                    if (array_ids.includes(value + "")) {
                        $input.append('<option selected value="' + value +
                            '">' +
                            index +
                            '</option>');
                    } else {
                        $input.append('<option value="' + value +
                            '">' +
                            index +
                            '</option>');
                    }

                });

            });

            Livewire.on('setDataFields', function(data) {
                // $(".reset-validation").text(" ");
                $data_updater = JSON.parse(data);
            });

            Livewire.on('setDescriptionAr', function(id, data) {
                var trixEditor_description_ar = $("#" + id);
                trixEditor_description_ar.attr('value', data);
            });

            Livewire.on('setDescriptionEn', function(data) {
                var trixEditor_description_en = document.getElementById("description_en");
                @this.set('description_en', trixEditor_description_en.getAttribute('value'));
            });
        });
    </script>

    <script>
        var trixEditor_description_ar = document.getElementById("description_ar");
        var trixEditor_description_en = document.getElementById("description_en");

        addEventListener("trix-blur", function(event) {
            @this.set('description_ar', trixEditor_description_ar.getAttribute('value'));
            @this.set('description_en', trixEditor_description_en.getAttribute('value'));
        });
    </script>
@endpush

</div>
