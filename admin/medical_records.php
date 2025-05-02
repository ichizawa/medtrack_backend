<?php
require_once './Auth/auth_check.php';
ob_start();
include __DIR__ . '/../conf.php';
?>
<link rel="stylesheet" href="assets/css/medical_records.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card header-card">
                <div class="card-body">
                    <h1 class="page-title">Medical Records</h1>
                    <p class="page-subtitle">Track and manage student medical documentation and compliance</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Records -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <!-- Tabs for record status -->
                    <ul class="nav nav-tabs mb-4" id="recordTabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" onclick="filterByTab('All')">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="filterByTab('Completed')">Completed</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="filterByTab('Expiring Soon')">Expiring Soon</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="filterByTab('Pending')">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="filterByTab('Expired')">Expired</a>
                        </li>
                    </ul>

                    <!-- Filters and Search Bar -->
                    <div class="d-flex justify-content-between mb-4 align-items-center flex-wrap p-3 rounded shadow-sm"
                        style="background-color: #f8f9fa;">
                        <div class="d-flex align-items-end gap-4 flex-wrap">
                            <div class="d-flex flex-column" style="min-width: 180px;">
                                <label for="filterStudent" class="form-label mb-1 fw-bold text-secondary">Student
                                    Name</label>
                                <select id="filterStudent" class="form-select shadow-sm">
                                    <option value="" selected disabled>Select Student Name</option>
                                    <option value="All">All Students</option>
                                    <?php
                                    $qry = 'SELECT * FROM users';
                                    $result = $conn->query($qry);
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
                                    }
                                    ?>
                                    <!-- Add more student names here -->
                                </select>
                            </div>
                            <div class="d-flex flex-column" style="min-width: 180px;">
                                <label for="filterStatus" class="form-label mb-1 fw-bold text-secondary">Status</label>
                                <select id="filterStatus" class="form-select shadow-sm">
                                    <option value="" selected disabled>Select Status</option>
                                    <option value="All">All Status</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Expiring Soon">Expiring Soon</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Expired">Expired</option>
                                    <!-- Add more status options here -->
                                </select>
                            </div>
                            <div class="d-flex flex-column" style="min-width: 180px;">
                                <label for="filterDocument" class="form-label mb-1 fw-bold text-secondary">Document
                                    Type</label>
                                <select id="filterDocument" class="form-select shadow-sm">
                                    <option value="" selected disabled>Select Document Type</option>
                                    <option value="All">All Document</option>
                                    <?php
                                    $documents = [
                                        'Flu Vaccine' => 1,
                                        'Pneumococcal Vaccine' => 2,
                                        'Hepatitis B Vaccine' => 3,
                                        'Covid-19 Vaccine' => 4,
                                        'X-Ray Result' => 5,
                                        'CBC Result' => 6,
                                        'Urine Test' => 7,
                                        'Fecal Test' => 8,
                                        'Stool Series' => 9,
                                        'Medical Certificate' => 10,
                                    ];
                                    foreach ($documents as $value => $key) {
                                        echo '<option value="' . $key . '">' . $value . '</option>';
                                    }
                                    ?>
                                    <!-- Add more document types here -->
                                </select>
                            </div>
                            <div class="d-flex align-items-end gap-2">
                                <button class="btn btn-primary shadow-sm" onclick="applyFilters()">Filter</button>
                                <button class="btn btn-outline-secondary shadow-sm"
                                    onclick="window.print()">Print</button>
                            </div>
                        </div>

                        <div class="d-flex flex-column align-items-end mt-3 mt-md-0" style="min-width: 250px;">
                            <label for="searchInput" class="form-label mb-1 fw-bold text-secondary">Search</label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="searchInput" class="form-control border-start-0"
                                    placeholder="Search records..." style="min-width: 200px;">
                            </div>
                        </div>
                    </div>

                    <!-- Records Table -->
                    <div class="table-responsive">
                        <table class="table medical-records-table" id="recordsTable">
                            <thead>
                                <tr>
                                    <th onclick="sortTable(0)">Record Name <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(1)">Student ID <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(2)">Student Name <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(3)">Document Type <i class="fas fa-sort"></i></th>
                                    <th>Attachment File</th>
                                    <th onclick="sortTable(5)">Expired Date <i class="fas fa-sort"></i></th>
                                    <th onclick="sortTable(6)">Status <i class="fas fa-sort"></i></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qry = 'SELECT * FROM records';
                                $result = $conn->query($qry);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $qr = "SELECT * FROM users WHERE id = '" . $row['user_id'] . "'";
                                        $result2 = $conn->query($qr);
                                        $row2 = $result2->fetch_assoc();
                                        ?>
                                        <tr>
                                            <td><?= $row['document_name'] ?></td>
                                            <td><?= $row2['id'] ?></td>
                                            <td>
                                                <div>
                                                    <span><?= $row2['first_name'] ?>         <?= $row2['last_name'] ?></span>
                                                </div>
                                            </td>
                                            <td><?= $row['document_type'] ?></td>
                                            <td><a href="../../assets/public/records/<?= urlencode(trim($row['file_name'])) ?>"
                                                    download>View File</a></td>
                                            <td><?= date('Y-m-d', strtotime($row['exp_date'])) ?></td>
                                            <td><span
                                                    class="status-badge completed"><?= $row['is_archived'] ? 'Archived' : 'Submitted' ?></span>
                                            </td>
                                            <td>
                                                <div class="actions">
                                                    <a href="#" class="btn btn-icon view-record" data-bs-toggle="modal"
                                                        data-bs-target="#viewRecordModal"
                                                        data-record='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>'
                                                        title="View Record">
                                                        <i class="fas fa-eye"></i>
                                                    </a>


                                                    <button class="btn btn-icon" title="Download"
                                                        onclick="downloadRecord(this)"><i class="fas fa-download"></i></button>
                                                    <button class="btn btn-icon" title="Delete" onclick="deleteRecord(this)"><i
                                                            class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>

                    <div class="pagination-wrapper">
                        <div class="pagination-info">Showing 1 to 5 of 10 entries</div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>

                    <div class="modal fade" id="viewRecordModal" tabindex="-1" aria-labelledby="viewRecordLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content shadow-lg border-0">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="viewRecordLabel">📄 Record Details</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="record-details-grid">
                                        <div><strong>ID:</strong> <span id="recordId"></span></div>
                                        <div><strong>Name:</strong> <span id="recordName"></span></div>
                                        <div><strong>Status:</strong> <span id="recordStatus"></span></div>
                                        <div><strong>Notes:</strong> <span id="recordNotes"></span></div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function filterByTab(status) {
        const rows = document.querySelectorAll('.medical-records-table tbody tr');

        rows.forEach(row => {
            const badge = row.querySelector('.status-badge');
            if (status === 'All') {
                row.style.display = '';
            } else if (badge && badge.innerText.trim().toLowerCase() === status.toLowerCase()) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Set active tab
        document.querySelectorAll('#recordTabs .nav-link').forEach(tab => tab.classList.remove('active'));
        const tabs = Array.from(document.querySelectorAll('#recordTabs .nav-link'));
        tabs.find(tab => tab.innerText.trim() === status || (status === 'All' && tab.innerText.trim() === 'All')).classList.add('active');
    }

    // Search Filter
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const input = this.value.toLowerCase();
        const rows = document.querySelectorAll('.medical-records-table tbody tr');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? '' : 'none';
        });
    });
    let sortDirection = {};

    function sortTable(columnIndex) {
        const table = document.getElementById("recordsTable");
        const rows = Array.from(table.tBodies[0].rows);
        const dir = sortDirection[columnIndex] === "asc" ? "desc" : "asc";
        sortDirection[columnIndex] = dir;

        rows.sort((a, b) => {
            const aText = a.cells[columnIndex].innerText.trim().toLowerCase();
            const bText = b.cells[columnIndex].innerText.trim().toLowerCase();

            if (!isNaN(Date.parse(aText)) && !isNaN(Date.parse(bText))) {
                return dir === "asc" ?
                    new Date(aText) - new Date(bText) :
                    new Date(bText) - new Date(aText);
            }

            return dir === "asc" ?
                aText.localeCompare(bText) :
                bText.localeCompare(aText);
        });

        // Append sorted rows back to the table
        rows.forEach(row => table.tBodies[0].appendChild(row));
    }

    document.querySelectorAll('.view-record').forEach(button => {
        button.addEventListener('click', function () {
            const recordData = JSON.parse(this.getAttribute('data-record'));
            console.log(recordData);

            document.getElementById('recordId').innerText = recordData.id;
            document.getElementById('recordName').innerText = recordData.document_name;
            document.getElementById('recordStatus').innerText = recordData.is_archived ? 'Archived' : 'Submitted';
            document.getElementById('recordNotes').innerText = recordData.note || 'No notes';
        });
    });


    function applyFilters() {
        // Get the selected filter values
        const student = document.getElementById('filterStudent').value.toLowerCase();
        const status = document.getElementById('filterStatus').value.toLowerCase();
        const documentType = document.getElementById('filterDocument').value.toLowerCase();

        // Select all rows in the table
        const rows = document.querySelectorAll('.medical-records-table tbody tr');

        // Loop through each row and apply the filter logic
        rows.forEach(row => {
            // Get the values from the row for comparison
            const studentName = row.querySelector('.student-info h6')?.innerText.toLowerCase() || '';
            const docType = row.querySelector('.document-type span')?.innerText.toLowerCase() || '';
            const statBadge = row.querySelector('.status-badge')?.innerText.toLowerCase() || '';

            // Check if the row matches the filter criteria for each field
            const matchStudent = (student === "all" || !student || studentName.includes(student));
            const matchStatus = (status === "all" || !status || statBadge.includes(status));
            const matchDocType = (documentType === "all" || !documentType || docType.includes(documentType));

            // Show the row if it matches all selected filter options, otherwise hide it
            row.style.display = (matchStudent && matchStatus && matchDocType) ? '' : 'none';
        });
    }

    // Download Record
    function downloadRecord(button) {
        const row = button.closest('tr');
        const studentName = row.querySelector('.student-info h6').innerText;
        alert('Downloading record for ' + studentName);
    }

    // Delete Record
    function deleteRecord(button) {
        const row = button.closest('tr');
        const studentName = row.querySelector('.student-info h6').innerText;
        if (confirm('Are you sure you want to delete the record for ' + studentName + '?')) {
            row.remove();
        }
    }

    // Initial filter set to 'All'
    filterByTab('All');
</script>

<?php
$pageContent = ob_get_clean();
include './Navigations/navbar.php';
?>