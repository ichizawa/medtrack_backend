<?php
require_once './Auth/auth_check.php';
ob_start();

include __DIR__ . '/../conf.php';

?>
<link rel="stylesheet" href="assets/css/list_of_students.css">

<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card header-card">
                <div class="card-body">
                    <h1 class="page-title">Student Medical Records</h1>
                    <p class="page-subtitle">Manage and track student medical documentation</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-2 mb-md-0">Student List</h5>
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="search-input" class="form-control border-start-0"
                            placeholder="Search by Name or ID">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table student-records-table">
                            <thead>
                                <tr>
                                    <th data-index="0">Student ID <i class="fas fa-sort sort-icon"></i></th>
                                    <th data-index="1">Student Name <i class="fas fa-sort sort-icon"></i></th>
                                    <th data-index="2">Phone <i class="fas fa-sort sort-icon"></i></th>
                                    <th data-index="3">Email <i class="fas fa-sort sort-icon"></i></th>
                                    <th data-index="4">Status <i class="fas fa-sort sort-icon"></i></th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qry = 'SELECT * FROM users';
                                $result = $conn->query($qry);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td>
                                                <div class="student-info d-flex align-items-center">
                                                    <img src="assets/img/photo.png" alt="Student" class="student-avatar me-2">
                                                    <div>
                                                        <h6 class="mb-0"><?= $row['first_name'] ?> <?= $row['last_name'] ?></h6>
                                                        <!-- <small>Nursing - Year 3</small> -->
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $row['phone'] ?></td>
                                            <td><?= $row['email'] ?></td>
                                            <td><span class="status-badge bg-success"><?= $row['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                                            <td>
                                                <div class="actions">
                                                    <button type="button" class="btn btn-icon" title="View Record"
                                                        onclick="window.location.href='student_details.php?id=<?= $row['id'] ?>'">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-icon" title="Edit Record"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button class="btn btn-icon" title="Delete Record"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <!-- <tbody>
                                <tr>
                                    <td>STU-05940</td>
                                    <td>
                                        <div class="student-info d-flex align-items-center">
                                            <img src="assets/img/photo.png" alt="Student" class="student-avatar me-2">
                                            <div>
                                                <h6 class="mb-0">John Doe</h6>
                                                <small>Nursing - Year 3</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>09171234567</td>
                                    <td>john.doe@example.com</td>
                                    <td><span class="status-badge bg-success">Active</span></td>
                                    <td>
                                        <div class="actions">
                                            <button class="btn btn-icon" title="View Record"><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-icon" title="Edit Record"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-icon" title="Delete Record"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>STU-05941</td>
                                    <td>
                                        <div class="student-info d-flex align-items-center">
                                            <img src="assets/img/photo.png" alt="Student" class="student-avatar me-2">
                                            <div>
                                                <h6 class="mb-0">Jane Smith</h6>
                                                <small>Nursing - Year 2</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>09953554653</td>
                                    <td>jane.smith@example.com</td>
                                    <td><span class="status-badge bg-secondary">Not Active</span></td>
                                    <td>
                                        <div class="actions">
                                            <button class="btn btn-icon" title="View Record"><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-icon" title="Edit Record"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-icon" title="Delete Record"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody> -->
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper d-flex justify-content-between align-items-center mt-3">
                        <div class="pagination-info">Showing 1 to 10 of 50 entries</div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sort/Filter/Search Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.querySelector('.student-records-table');
        const headers = table.querySelectorAll('thead th[data-index]');
        const icons = table.querySelectorAll('.sort-icon');

        let currentSort = {
            index: null,
            ascending: true
        };

        function sortTable(index, isNumeric = false) {
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const ascending = currentSort.index === index ? !currentSort.ascending : true;

            rows.sort((a, b) => {
                let textA = a.cells[index].textContent.trim();
                let textB = b.cells[index].textContent.trim();

                if (index === 1) { // For student name inside h6
                    textA = a.cells[index].querySelector('h6').textContent.trim();
                    textB = b.cells[index].querySelector('h6').textContent.trim();
                }

                const valA = isNumeric ? parseFloat(textA) : textA.toLowerCase();
                const valB = isNumeric ? parseFloat(textB) : textB.toLowerCase();

                return ascending ? valA.localeCompare(valB) : valB.localeCompare(valA);
            });

            const tbody = table.querySelector('tbody');
            rows.forEach(row => tbody.appendChild(row));

            icons.forEach(icon => {
                icon.classList.remove('fa-arrow-up', 'fa-arrow-down');
                icon.classList.add('fa-sort');
            });

            const currentIcon = headers[index].querySelector('.sort-icon');
            currentIcon.classList.remove('fa-sort');
            currentIcon.classList.add(ascending ? 'fa-arrow-up' : 'fa-arrow-down');

            currentSort.index = index;
            currentSort.ascending = ascending;
        }

        headers.forEach(header => {
            header.addEventListener('click', () => {
                const index = parseInt(header.getAttribute('data-index'));
                const isNumeric = header.textContent.toLowerCase().includes('id');
                sortTable(index, isNumeric);
            });
        });

        document.getElementById('search-input').addEventListener('input', function() {
            const value = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const id = row.cells[0].textContent.toLowerCase();
                const name = row.cells[1].querySelector('h6').textContent.toLowerCase();
                row.style.display = id.includes(value) || name.includes(value) ? '' : 'none';
            });
        });
    });
</script>

<?php
$pageContent = ob_get_clean();
include './Navigations/navbar.php';
?>