@extends('layout.navigation')

@section('title','Chat')

@section('main-content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Font Awesome + jQuery -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="flex h-screen">

  <!-- ================= SIDEBAR ================= -->
  <div class="w-1/4 bg-sky-100 border-r border-sky-300 flex flex-col">
    <h2 class="text-lg font-bold p-4 bg-sky-300 text-white">Patients</h2>

    <div class="p-2">
      <input id="patientSearch" type="text"
        placeholder="Search patient..."
        class="w-full border rounded-lg p-2 focus:ring focus:ring-sky-400">
    </div>

    <ul id="patientList" class="flex-1 overflow-y-auto divide-y"></ul>
  </div>

  <!-- ================= CHAT ================= -->
  <div class="flex-1 flex flex-col bg-slate-300">
    <div id="chatHeader"
      class="p-4 bg-sky-300 text-white font-bold">
      Select a patient
    </div>

    <div id="messagesBox"
      class="flex-1 overflow-y-auto p-4 space-y-3">
    </div>

    <!-- INPUT -->
    <div class="p-4 border-t flex items-center gap-2 bg-white">

      <!-- FILE -->
      <label for="adminFileInput"
        class="cursor-pointer text-sky-600 text-xl">
        <i class="fa-solid fa-paperclip"></i>
      </label>
      <input type="file" id="adminFileInput" class="hidden">

      <!-- MESSAGE -->
      <input id="messageInput"
        type="text"
        placeholder="Type a message..."
        class="flex-1 border rounded-lg p-2 focus:ring focus:ring-sky-400">

      <!-- SEND -->
      <button id="sendBtn"
        class="bg-sky-500 text-white px-4 py-2 rounded-lg">
        <i class="fa-solid fa-paper-plane"></i>
      </button>
    </div>
  </div>
</div>

<script>
/* ================= GLOBAL ================= */
let currentPatient = null;
const currentStore = "{{ session('active_branch_id') }}";
const authUserId = {{ auth()->id() }};
let allPatients = [];

/* ================= PATIENT LIST ================= */
function loadPatients() {
  fetch("{{ route('patients.list') }}")
    .then(res => res.json())
    .then(patients => {
      allPatients = patients;
      renderPatientList(patients);
    });
}

function renderPatientList(patients) {
  const list = document.getElementById("patientList");
  list.innerHTML = "";

  patients.forEach(p => {
    const li = document.createElement("li");
    li.className = `
      p-3 cursor-pointer hover:bg-sky-200
      ${currentPatient === p.id ? 'bg-sky-300' : ''}
    `;

    li.innerHTML = `
      <strong>${p.full_name}</strong><br>
      <small class="text-gray-600">
        ${p.latest_message ?? 'No messages yet'}
      </small>
    `;

    li.onclick = () => {
      currentPatient = p.id;
      document.getElementById("chatHeader").textContent = p.full_name;
      loadMessages(currentStore, p.id);
    };

    list.appendChild(li);
  });
}

/* ================= SEARCH ================= */
$('#patientSearch').on('input', function () {
  const q = this.value.toLowerCase();
  renderPatientList(
    allPatients.filter(p =>
      p.full_name.toLowerCase().includes(q)
    )
  );
});

/* ================= LOAD MESSAGES ================= */
function loadMessages(storeId, userId) {
  fetch(`/messages/${storeId}/${userId}`)
    .then(res => res.json())
    .then(messages => {
      const box = document.getElementById("messagesBox");
      box.innerHTML = "";

      messages.forEach(msg => {
        const mine = msg.sender_id === authUserId;
        const cls = mine
          ? "bg-sky-500 text-white ml-auto"
          : "bg-sky-200 text-sky-900";

        if (msg.file_path) {
          box.innerHTML += `
            <div class="${cls} p-2 rounded-lg max-w-md shadow">
              <i class="fa-solid fa-file"></i>
              <a href="/storage/${msg.file_path}"
                 target="_blank"
                 class="underline ml-2">
                ${msg.message}
              </a>
            </div>`;
        } else {
          box.innerHTML += `
            <div class="${cls} p-2 rounded-lg max-w-md shadow">
              ${msg.message}
            </div>`;
        }
      });

      box.scrollTop = box.scrollHeight;
    });
}

/* ================= SEND TEXT ================= */
$('#sendBtn').on('click', sendMessage);
$('#messageInput').on('keypress', e => {
  if (e.key === 'Enter') sendMessage();
});

function sendMessage() {
  const text = $('#messageInput').val().trim();
  if (!text || !currentPatient) return;

  fetch("{{ route('messages.store') }}", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
    },
    body: JSON.stringify({
      store_id: currentStore,
      user_id: currentPatient,
      message: text
    })
  })
  .then(res => res.json())
  .then(r => {
    if (r.status === 'success') {
      $('#messageInput').val('');
      loadMessages(currentStore, currentPatient);
      loadPatients();
    }
  });
}

/* ================= FILE UPLOAD (ADMIN) ================= */
$('#adminFileInput').on('change', function () {

  if (!currentPatient) {
    alert('Select a patient first');
    return;
  }

  const file = this.files[0];
  if (!file) return;

  const fd = new FormData();
  fd.append('file', file);
  fd.append('store_id', currentStore);
  fd.append('user_id', currentPatient); // ✅ REQUIRED

  $.ajax({
    url: "{{ route('messages.upload') }}",
    type: "POST",
    data: fd,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success(res) {
      if (res.status === 'success') {
        loadMessages(currentStore, currentPatient);
        loadPatients();
        $('#adminFileInput').val('');
      }
    },
    error(err) {
      console.error(err);
      alert('Upload failed');
    }
  });
});

/* ================= AUTO REFRESH ================= */
setInterval(() => {
  loadPatients();
  if (currentPatient) {
    loadMessages(currentStore, currentPatient);
  }
}, 3000);

/* INIT */
loadPatients();
</script>
@endsection
