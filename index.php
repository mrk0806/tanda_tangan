<!DOCTYPE html>
<html>
<head>
    <title>Online Signature</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <style>
        .signature-container {
            display: inline-block;
            margin-right: 20px;
        }
        .signature-pad {
            border: 2px solid #c3c3c3;
            width: 300px;
            height: 200px;
            margin-bottom: 10px;
        }
        .signature-image {
            display: none;
            max-width: 300px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Create Your Signature</h2>
    <div class="signature-container">
        <h3>Signature 1</h3>
        <div id="signature-pad-1" class="signature-pad">
            <canvas></canvas>
        </div>
        <button class="clear" data-target="1">Clear</button>
        <button class="save" data-target="1">Save Signature</button>
        <img id="signature-image-1" class="signature-image" src="" alt="Signature 1">
    </div>

    <div class="signature-container">
        <h3>Signature 2</h3>
        <div id="signature-pad-2" class="signature-pad">
            <canvas></canvas>
        </div>
        <button class="clear" data-target="2">Clear</button>
        <button class="save" data-target="2">Save Signature</button>
        <img id="signature-image-2" class="signature-image" src="" alt="Signature 2">
    </div>

    <div class="signature-container">
        <h3>Signature 3</h3>
        <div id="signature-pad-3" class="signature-pad">
            <canvas></canvas>
        </div>
        <button class="clear"  data-target="3">Clear</button>
        <button class="save" data-target="3">Save Signature</button>
        <img id="signature-image-3" class="signature-image" src="" alt="Signature 3">
    </div>

    <script>
        $(document).ready(function(){
    var signaturePads = [];
    var signatureImages = [];

    // Inisialisasi signature pads
    for (var i = 1; i <= 3; i++) {
        (function(index) {
            var canvas = document.querySelector("#signature-pad-" + index + " canvas");
            var signaturePad = new SignaturePad(canvas);
            signaturePads.push(signaturePad);
            $("#signature-image-" + index).hide(); // Sembunyikan gambar jika ada

            // Event listener untuk tombol Clear
            $(".clear[data-target='" + index + "']").click(function(){
                clearCanvas(index);
            });

            // Event listener untuk tombol Save
            $(".save[data-target='" + index + "']").click(function(){
                saveSignature(index);
            });
        })(i);
    }

    // Fungsi untuk membersihkan canvas
    function clearCanvas(index) {
        signaturePads[index - 1].clear();
    }

    // Fungsi untuk menyimpan tanda tangan
    function saveSignature(index) {
        if (signaturePads[index - 1].isEmpty()) {
            alert("Please provide a signature first.");
        } else {
            var signatureData = signaturePads[index - 1].toDataURL();
            $.ajax({
                type: "POST",
                url: "save_signature.php",
                data: { signature: signatureData },
                success: function(response) {
                    signaturePads[index - 1].clear();
                    $("#signature-pad-" + index).hide(); // Sembunyikan elemen canvas
                    $('button.clear[data-target="' + index + '"]').hide(); // Sembunyikan tombol "Clear"
                    $('button.save[data-target="' + index + '"]').hide(); // Sembunyikan tombol "Save"
                    $("#signature-image-" + index).attr("src", response).show(); // Tampilkan gambar tanda tangan
                },
                error: function(xhr, status, error) {
                    alert("An error occurred while saving the signature.");
                    console.error(xhr.responseText);
                }
            });
        }
    }
});

    </script>
</body>
</html>
