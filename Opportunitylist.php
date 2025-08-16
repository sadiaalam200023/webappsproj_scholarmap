<?php
include 'database.php';

// Handle filters (optional)
$type = $_GET['type'] ?? '';
$location = $_GET['location'] ?? '';

$sql = "SELECT o.opportunity_id, o.title, o.description, o.deadline, o.location, o.type, org.name AS insname
        FROM opportunities o
        JOIN organizations org ON o.org_id = org.org_id
        WHERE 1=1";

$params = [];
$types = "";

if (!empty($type)) {
    $sql .= " AND o.type = ?";
    $params[] = $type;
    $types .= "s";
}
if (!empty($location)) {
    $sql .= " AND o.location = ?";
    $params[] = $location;
    $types .= "s";
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="styles1.css">
</head>
<body>

<div class="sidebar">
  <h2>ScholarMap</h2>
  <a href="Opportunitylist.html" class="">View Opportunity list</a>
  <a href="studentdash.html">Edit profile</a>
  <a href="appliedlist.html">View Applied opportunity list</a>
 
  <a href="index.html">Logout</a>
</div>



<!-- Dynamic Opportunity List -->
  <div class="opportunity-list">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="opportunity-card">
        <div class="opportunity-info">
          <h3><?php echo htmlspecialchars($row['insname']); ?></h3>
          <p><strong>Opportunity Title:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
          <p><strong>Opportunity Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
          <p><strong>Deadline:</strong> <?php echo htmlspecialchars($row['deadline']); ?></p>
          <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
          <p><strong>Opportunity type:</strong> <?php echo htmlspecialchars($row['type']); ?></p>
        </div>
        <div class="opportunity-action">
          <a href="apply.php?id=<?php echo $row['opportunity_id']; ?>" class="apply-btn">Apply</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
  <div class="filter-section">
    <form method="GET" action="" class="filter-form">
      <select name="type">
        <option value="">Types</option>
        <option value="Internship">Internship</option>
        <option value="job">Part-Time Job</option>
        <option value="volunteering">Volunteering</option>
        <option value="competition">Competition</option>
        <option value="workshop">Workshop</option>
      </select>

      <select name="location">
        <option value="">Locations</option>
        <option value="Dhaka">Dhaka</option>
        <option value="Chattogram">Chattogram</option>
        <option value="Rajshahi">Rajshahi</option>
        <option value="Sylhet">Other</option>
        <option value="Online">Online</option>
        
      </select>

      <button type="submit">Filter</button>
    </form>
  </div>

  
  

  

</body>
</html>




