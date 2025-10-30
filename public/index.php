<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Management Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>College Management Platform</h1>
        <p>Unified portal for staff, students, parents, alumni, and recruiters.</p>
    </header>

    <main>
        <section id="parent-portal">
            <h2>Parent Dashboard Preview</h2>
            <div class="card">
                <div>
                    <label for="parentId">Parent ID</label>
                    <input type="number" id="parentId" value="1" min="1">
                    <button id="loadParent">Load Dashboard</button>
                </div>
                <pre id="parentOutput">Select a parent to view progress.</pre>
            </div>
        </section>

        <section id="analytics">
            <h2>Engagement Analytics</h2>
            <div class="card">
                <label for="analyticsParentId">Parent ID</label>
                <input type="number" id="analyticsParentId" value="1" min="1">
                <button id="loadAnalytics">Calculate</button>
                <pre id="analyticsOutput">Analytics data will appear here.</pre>
            </div>
        </section>

        <section id="features">
            <h2>Platform Modules</h2>
            <div class="grid">
                <article>
                    <h3>Academic & Assessment</h3>
                    <ul>
                        <li>Course delivery, lesson planning, and outcome mapping.</li>
                        <li>Comprehensive attendance with parent alerts.</li>
                        <li>Online/offline exams (MCQ, MSQ, NAT) with auto grading.</li>
                    </ul>
                </article>
                <article>
                    <h3>Staff Operations</h3>
                    <ul>
                        <li>Unified HR, payroll, leave, and performance reviews.</li>
                        <li>Exam cell scheduling with online exam integrations.</li>
                        <li>Support desks for IT, library, hostel, and transport.</li>
                    </ul>
                </article>
                <article>
                    <h3>Community & Engagement</h3>
                    <ul>
                        <li>Alumni mentorship and events.</li>
                        <li>Company portal for placements and analytics.</li>
                        <li>Parent forums, mentorship logs, and career updates.</li>
                    </ul>
                </article>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> College Management Platform</p>
    </footer>

    <script>
        async function fetchParent(parentId) {
            const response = await fetch(`api.php?path=/api/parents/${parentId}`);
            if (!response.ok) {
                throw new Error('Unable to load parent data');
            }
            return response.json();
        }

        async function fetchAnalytics(parentId) {
            const response = await fetch(`api.php?path=/api/analytics/parent-engagement&parent_id=${parentId}`);
            if (!response.ok) {
                throw new Error('Unable to load analytics');
            }
            return response.json();
        }

        document.getElementById('loadParent').addEventListener('click', async () => {
            const parentId = document.getElementById('parentId').value;
            const output = document.getElementById('parentOutput');
            output.textContent = 'Loading...';
            try {
                const data = await fetchParent(parentId);
                output.textContent = JSON.stringify(data, null, 2);
            } catch (error) {
                output.textContent = error.message;
            }
        });

        document.getElementById('loadAnalytics').addEventListener('click', async () => {
            const parentId = document.getElementById('analyticsParentId').value;
            const output = document.getElementById('analyticsOutput');
            output.textContent = 'Computing...';
            try {
                const data = await fetchAnalytics(parentId);
                output.textContent = JSON.stringify(data, null, 2);
            } catch (error) {
                output.textContent = error.message;
            }
        });
    </script>
</body>
</html>
