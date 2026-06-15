// Bisa dipanggil setelah inisialisasi vendor quill

// Variabel pembantu
/**
 * Variabel ini:
 *  1. Di sematkan di modules.toolbar
 */
const qnQuillToolbarOptions = [
    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    // [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

    ['bold', 'italic', 'underline'],        // toggled buttons
    
    [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'align': [] }],

    ['link', 'image', 'video']
];

// Jika file js ini dipanggil otomatis semua textare dengan class .text-editor akan diubah menjadi text rich
const qnQuill = new Quill('.text-editor', {
    modules: {
        toolbar: qnQuillToolbarOptions
    },
    theme: 'snow'
});