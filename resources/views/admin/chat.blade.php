@extends('layout.navigation')

@section('title','Chat')

@section('main-content')
<meta name="csrf-token" content="{{ csrf_token() }}">


<div class="flex h-[calc(100vh-8.5rem)] min-h-[400px] rounded-lg overflow-hidden shadow">

  @php
      $chatBranch = \App\Models\Store::find(session('active_branch_id'));
  @endphp

  <!-- ================= SIDEBAR ================= -->
  <div class="w-1/4 bg-sky-100 border-r border-sky-300 flex flex-col">
    <div class="p-4 bg-sky-300 text-white">
      <h2 id="sidebarTitle" class="text-lg font-bold leading-tight">Patients</h2>
      <p class="text-xs opacity-90 mt-0.5">
        <i class="fa-solid fa-code-branch mr-1"></i>{{ $chatBranch->name ?? 'No branch selected' }}
      </p>
    </div>

    {{-- Patients = usapan sa pasyente. Branches = branch-to-branch na mensahe
         ng staff; nakikita ito ng lahat ng naka-aktibo sa tumatanggap na branch. --}}
    <div class="flex text-sm font-semibold bg-sky-200">
      <button id="tabPatients" type="button"
        class="flex-1 py-2 border-b-2 border-sky-600 text-sky-900">
        Patients
      </button>
      <button id="tabBranches" type="button"
        class="flex-1 py-2 border-b-2 border-transparent text-sky-700">
        Branches
        <span id="branchUnreadBadge"
          class="hidden ml-1 inline-flex items-center justify-center min-w-[18px] h-4 px-1 text-[10px] font-bold text-white bg-red-500 rounded-full"></span>
      </button>
    </div>

    <div class="p-2">
      <input id="patientSearch" type="text"
        placeholder="Search patient..."
        class="w-full border rounded-lg p-2 focus:ring focus:ring-sky-400">
    </div>

    <ul id="patientList" class="flex-1 overflow-y-auto divide-y"></ul>
    <ul id="branchList" class="flex-1 overflow-y-auto divide-y hidden"></ul>
  </div>

  <!-- ================= CHAT ================= -->
  <div class="flex-1 flex flex-col bg-slate-300">
    <div class="p-4 bg-sky-300 text-white">
      <div id="chatHeader" class="font-bold">Select a patient</div>
      <div id="chatSubHeader" class="text-xs opacity-90 mt-0.5">
        <i class="fa-solid fa-code-branch mr-1"></i>{{ $chatBranch->name ?? 'No branch selected' }}
      </div>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script>
/* ================= GLOBAL ================= */
let currentPatient = null;
let currentBranch  = null;   // kausap na branch (branch-to-branch mode)
let chatMode       = 'patients'; // 'patients' | 'branches'
const currentStore = "{{ session('active_branch_id') }}";
const authUserId = {{ auth()->id() }};
let allPatients = [];

/* ================= TAB SWITCH ================= */
function setChatMode(mode) {
  chatMode = mode;
  const isPatients = mode === 'patients';

  document.getElementById('patientList').classList.toggle('hidden', !isPatients);
  document.getElementById('branchList').classList.toggle('hidden', isPatients);
  document.getElementById('patientSearch').classList.toggle('hidden', !isPatients);
  document.getElementById('sidebarTitle').textContent = isPatients ? 'Patients' : 'Branches';

  document.getElementById('tabPatients').className =
    'flex-1 py-2 border-b-2 ' + (isPatients ? 'border-sky-600 text-sky-900' : 'border-transparent text-sky-700');
  document.getElementById('tabBranches').className =
    'flex-1 py-2 border-b-2 ' + (isPatients ? 'border-transparent text-sky-700' : 'border-sky-600 text-sky-900');

  document.getElementById('messagesBox').innerHTML = '';
  document.getElementById('chatHeader').textContent = isPatients ? 'Select a patient' : 'Select a branch';
  currentPatient = null;
  currentBranch  = null;

  isPatients ? loadPatients() : loadBranches();
}

document.getElementById('tabPatients').onclick = () => setChatMode('patients');
document.getElementById('tabBranches').onclick = () => setChatMode('branches');

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

    const unreadBadge = p.unread_count > 0
      ? `<span class="ml-2 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full">${p.unread_count}</span>`
      : "";

    li.innerHTML = `
      <div class="flex items-center justify-between">
        <strong>${p.full_name}</strong>${unreadBadge}
      </div>
      <small class="${p.unread_count > 0 ? 'text-gray-900 font-semibold' : 'text-gray-600'}">
        ${p.latest_message ?? 'No messages yet'}
      </small>
    `;

    li.onclick = () => {
      currentPatient = p.id;
      document.getElementById("chatHeader").textContent = p.full_name;
      loadMessages(currentStore, p.id);
      loadPatients(); // refresh unread badges
    };

    list.appendChild(li);
  });
}

/* ================= BRANCH LIST (branch-to-branch) ================= */
function loadBranches() {
  fetch("{{ route('branch.messages.list') }}")
    .then(res => res.json())
    .then(renderBranchList);
}

function renderBranchList(branches) {
  const list = document.getElementById('branchList');
  list.innerHTML = '';

  if (!branches.length) {
    list.innerHTML = `
      <li class="p-4 text-sm text-gray-600">
        Walang ibang branch na makakausap. Pumili muna ng branch sa sidebar.
      </li>`;
    updateBranchBadge(0);
    return;
  }

  let totalUnread = 0;

  branches.forEach(b => {
    totalUnread += b.unread_count;

    const li = document.createElement('li');
    li.className = 'p-3 cursor-pointer hover:bg-sky-200 ' + (currentBranch === b.id ? 'bg-sky-300' : '');

    const unreadBadge = b.unread_count > 0
      ? `<span class="ml-2 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full">${b.unread_count}</span>`
      : '';

    li.innerHTML = `
      <div class="flex items-center justify-between">
        <strong>${b.name}</strong>${unreadBadge}
      </div>
      <small class="${b.unread_count > 0 ? 'text-gray-900 font-semibold' : 'text-gray-600'}">
        ${b.latest_message ?? 'No messages yet'}
      </small>
    `;

    li.onclick = () => {
      currentBranch = b.id;
      document.getElementById('chatHeader').textContent = b.name;
      loadBranchMessages(b.id);
      loadBranches();
    };

    list.appendChild(li);
  });

  updateBranchBadge(totalUnread);
}

function updateBranchBadge(count) {
  const badge = document.getElementById('branchUnreadBadge');
  badge.textContent = count;
  badge.classList.toggle('hidden', count === 0);
}

function loadBranchMessages(storeId) {
  fetch(`/branch-messages/${storeId}`)
    .then(res => res.json())
    .then(messages => {
      if (!Array.isArray(messages)) return;

      const box = document.getElementById('messagesBox');
      box.innerHTML = '';

      messages.forEach(msg => {
        const cls = msg.mine ? 'bg-sky-500 text-white ml-auto' : 'bg-sky-200 text-sky-900';
        const body = msg.file_url
          ? `<i class="fa-solid fa-file"></i><a href="${msg.file_url}" target="_blank" class="underline ml-2">${msg.message}</a>`
          : msg.message;

        box.innerHTML += `
          <div class="${cls} p-2 rounded-lg max-w-md shadow">
            <div class="text-[10px] opacity-80">${msg.sender_name}${msg.sender_role ? ' · ' + msg.sender_role : ''}</div>
            ${body}
            <div class="text-[10px] opacity-70 mt-1">${msg.created_at}</div>
          </div>`;
      });

      box.scrollTop = box.scrollHeight;
    });
}

function sendBranchMessage(text) {
  fetch("{{ route('branch.messages.store') }}", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    body: JSON.stringify({ to_store_id: currentBranch, message: text })
  })
    .then(res => res.json())
    .then(r => {
      if (r.status === 'success') {
        $('#messageInput').val('');
        loadBranchMessages(currentBranch);
        loadBranches();
      }
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
  if (!text) return;

  if (chatMode === 'branches') {
    if (!currentBranch) return;
    sendBranchMessage(text);
    return;
  }

  if (!currentPatient) return;

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

  const isBranchMode = chatMode === 'branches';

  if (isBranchMode ? !currentBranch : !currentPatient) {
    alert(isBranchMode ? 'Select a branch first' : 'Select a patient first');
    return;
  }

  const file = this.files[0];
  if (!file) return;

  const fd = new FormData();
  fd.append('file', file);

  if (isBranchMode) {
    fd.append('to_store_id', currentBranch);
  } else {
    fd.append('store_id', currentStore);
    fd.append('user_id', currentPatient); // ✅ REQUIRED
  }

  $.ajax({
    url: isBranchMode ? "{{ route('branch.messages.upload') }}" : "{{ route('messages.upload') }}",
    type: "POST",
    data: fd,
    contentType: false,
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },

    // 👉 SWEETALERT LOADER
    beforeSend() {
      Swal.fire({
        title: 'Uploading file...',
        text: 'Please wait',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
    },

    success(res) {
      Swal.close(); // ❌ close loader

      if (res.status === 'success') {
        if (isBranchMode) {
          loadBranchMessages(currentBranch);
          loadBranches();
        } else {
          loadMessages(currentStore, currentPatient);
          loadPatients();
        }
        $('#adminFileInput').val('');
      }
    },

    error(err) {
      Swal.close(); // ❌ close loader
      console.error(err);

      Swal.fire({
        icon: 'error',
        title: 'Upload failed',
        text: 'Unable to upload file. Please try again.'
      });
    }
  });
});


/* ================= AUTO REFRESH ================= */
setInterval(() => {
  if (chatMode === 'branches') {
    loadBranches();
    if (currentBranch) loadBranchMessages(currentBranch);
    return;
  }

  loadPatients();
  if (currentPatient) {
    loadMessages(currentStore, currentPatient);
  }
  // Panatilihing tama ang badge ng Branches kahit nasa Patients tab.
  fetch("{{ route('branch.messages.list') }}")
    .then(res => res.json())
    .then(branches => updateBranchBadge(
      Array.isArray(branches) ? branches.reduce((sum, b) => sum + b.unread_count, 0) : 0
    ));
}, 3000);

/* INIT */
loadPatients();
</script>
@endsection
