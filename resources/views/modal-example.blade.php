<button onclick="openModal(this)" data-modal="#modal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
    Open Modal
</button>

<div id="modal" class="fixed z-10 inset-0 bg-black/10 bg-opacity-50 hidden justify-center items-center">
    <div class="bg-white p-6 rounded-xl shadow-lg w-96 animate-scaleIn">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Modal Title</h2>
            <button onclick="closeModal(this)" data-modal="#modal" class="text-gray-500 hover:text-black text-xl">&times;</button>
        </div>

        <p class="text-gray-600">
            This is a simple modal using TailwindCSS. You can put text, forms, anything here.
        </p>

        <div class="mt-6 flex justify-end gap-2">
            <button onclick="closeModal(this)" data-modal="#modal" class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                Cancel
            </button>

            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Submit
            </button>
        </div>
    </div>
</div>

<script>
    function openModal(element) {
            const modalId = element.getAttribute('data-modal');
            const modal = document.getElementById(modalId);

            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }

        function closeModal(element) {
            const modalId = element.getAttribute('data-modal');
            const modal = document.getElementById(modalId);

            modal.classList.remove("flex");
            modal.classList.add("hidden");
        }
</script>
