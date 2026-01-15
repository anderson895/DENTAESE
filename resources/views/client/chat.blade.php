    @extends('layout.cnav')

    @section('title', 'Chat')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('main-content')
    <div class="flex h-screen">
      
      <!-- Sidebar (Branches) -->
      <div class="w-1/4 bg-sky-100 border-r border-sky-300 flex flex-col">
        <h2 class="text-lg font-bold p-4 bg-sky-300 text-white">Branches</h2>
        <ul id="branchList" class="flex-1 overflow-y-auto divide-y divide-sky-200"></ul>
      </div>
      
      <!-- Chat Window -->
      <div class="flex-1 flex flex-col bg-slate-300">
        <div id="chatHeader" class="p-4 bg-sky-300 text-white font-bold">Select a branch</div>
        <div id="messagesBox" class="flex-1 overflow-y-auto p-4 space-y-3"></div>
        <div class="p-4 border-t border-sky-300 flex items-center gap-2">
        
        <!-- File Upload -->
        <label for="fileInput"
          class="cursor-pointer text-sky-600 hover:text-sky-800 text-xl">
          <i class="fa-solid fa-paperclip"></i>
        </label>

        <input type="file" id="fileInput" class="hidden">

        <!-- Message Input -->
        <input id="messageInput" type="text" placeholder="Type a message..."
          class="flex-1 border rounded-lg p-2 focus:outline-none focus:ring focus:ring-sky-400">

        <!-- Send Button -->
        <button id="sendBtn"
          class="bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600">
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>

      </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>



$('#fileInput').on('change', function () {
  if (!currentBranch) {
    alert("Please select a branch first");
    return;
  }

  let file = this.files[0];
  if (!file) return;

  let formData = new FormData();
  formData.append('file', file);
  formData.append('store_id', currentBranch);

  $.ajax({
    url: "{{ route('patient.messages.upload') }}",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },

    // 👉 SWEETALERT LOADER
    beforeSend: function () {
      Swal.fire({
        title: 'Uploading...',
        text: 'Please wait',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
    },

    success: function (res) {
      Swal.close(); // ❌ close loader

      if (res.status === 'success') {
        $('#messagesBox').append(`
          <div class="bg-sky-500 text-white p-2 rounded-lg max-w-md ml-auto shadow">
            <i class="fa-solid fa-file"></i>
            <a href="${res.file_url}" target="_blank" class="underline ml-2">
              ${res.file_name}
            </a>
          </div>
        `);
        $('#messagesBox').scrollTop($('#messagesBox')[0].scrollHeight);
        $('#fileInput').val('');
        loadBranches();
      }
    },

    error: function () {
      Swal.close(); // ❌ close loader
      Swal.fire({
        icon: 'error',
        title: 'Upload failed',
        text: 'File upload failed. Please try again.'
      });
    }
  });
});






    let currentBranch = null;
    const authUserId = {{ auth()->id() }};

    // ✅ Load branches (PATIENT route)
    function loadBranches() {
      fetch("{{ route('patient.branches.list') }}")
        .then(res => res.json())
        .then(branches => {
          const branchList = document.getElementById("branchList");
          branchList.innerHTML = "";

          branches.forEach(branch => {
            const lastMsg = branch.latest_message
              ? branch.latest_message.message
              : "No messages yet";

            const li = document.createElement("li");
            li.className = `p-3 cursor-pointer border-b border-sky-200 hover:bg-sky-200 transition
              ${currentBranch === branch.id ? "bg-sky-300" : ""}`;

            li.innerHTML = `
              <strong>${branch.name}</strong><br>
              <small class="text-gray-600">${lastMsg}</small>
            `;

            li.addEventListener("click", () => {
              currentBranch = branch.id;
              document.getElementById("chatHeader").textContent = branch.name;
              loadMessages(branch.id, branch.name);
              loadBranches(); // refresh highlight
            });

            branchList.appendChild(li);
          });
        })
        .catch(err => console.error("Error loading branches:", err));
    }

    // ✅ Load messages for selected branch
    function loadMessages(storeId, branchName) {
      fetch(`/patient/messages/${storeId}`)
        .then(res => res.json())
        .then(messages => {
          const box = document.getElementById("messagesBox");
          box.innerHTML = "";

          messages.forEach(msg => {
          const isMine = msg.sender_id === authUserId;
          const msgClass = isMine
            ? "bg-sky-500 text-white ml-auto"
            : "bg-sky-200 text-sky-900";

          // ✅ FILE MESSAGE
          if (msg.file_path) {
            box.innerHTML += `
              <div class="${msgClass} p-2 rounded-lg max-w-md shadow">
                <i class="fa-solid fa-file"></i>
                <a href="/storage/${msg.file_path}"
                  target="_blank"
                  class="underline ml-2">
                  ${msg.message}
                </a>
              </div>
            `;
          } 
          // ✅ TEXT MESSAGE
          else {
            box.innerHTML += `
              <div class="${msgClass} p-2 rounded-lg max-w-md shadow">
                ${msg.message}
              </div>
            `;
          }
        });


          box.scrollTop = box.scrollHeight;
        })
        .catch(err => console.error("Error loading messages:", err));
    }

    // ✅ Send message
    document.getElementById("sendBtn").addEventListener("click", sendMessage);
    document.getElementById("messageInput").addEventListener("keypress", e => {
      if (e.key === "Enter") sendMessage();
    });

    function sendMessage() {
      const input = document.getElementById("messageInput");
      const text = input.value.trim();
      if (!text || !currentBranch) return;

      fetch("{{ route('patient.messages.store') }}", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content")
        },
        body: JSON.stringify({
          store_id: currentBranch,
          message: text
        })
      })
        .then(res => res.json())
        .then(resp => {
          if (resp.status === "success") {
            const box = document.getElementById("messagesBox");
            box.innerHTML += `
              <div class="bg-sky-500 text-white p-2 rounded-lg max-w-md ml-auto shadow">
                ${resp.message.message}
              </div>`;
            input.value = "";
            box.scrollTop = box.scrollHeight;
            loadBranches(); // update latest message
          }
        })
        .catch(err => console.error("Send failed:", err));
    }

    // 🔄 Auto refresh
    setInterval(() => {
      loadBranches();
      if (currentBranch) {
        loadMessages(currentBranch, document.getElementById("chatHeader").textContent);
      }
    }, 3000);

    // 🚀 Initial load
    loadBranches();
    </script>

    @endsection
