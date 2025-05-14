@props([
    'name',
    'label' => '',
    'placeholder' => '',
    'value' => old($name),
])

<div class="mb-4">
    @if ($label)
        <label for="{{ $name }}" class="block font-medium mb-1">{{ $label }}</label>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        class="hidden" {{-- hide original textarea; content is handled by CKEditor --}}
    >{{ $value }}</textarea>

    @error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

@once
    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    @endpush
@endonce

@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#{{ $name }}'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'link',
                    'bulletedList', 'numberedList',
                    '|', 'undo', 'redo'
                ],
                ui: {
                    viewportOffset: {
                        top: 100
                    }
                }
            })
            .then(editor => {
                // Force background and text color to avoid invisible content in dark themes
                editor.editing.view.change(writer => {
                    const root = editor.editing.view.document.getRoot();
                    writer.setStyle('color', '#000000', root);
                    writer.setStyle('background-color', '#ffffff', root);
                    writer.setStyle('padding', '1rem', root);
                });

                // Sync content back to textarea on change (for form submission)
                editor.model.document.on('change:data', () => {
                    document.querySelector('#{{ $name }}').value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
