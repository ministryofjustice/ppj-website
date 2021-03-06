<?php
/**
 * Template Name: Find a job
 */

include 'page-header.php';

$jobTitle          = get_field('job_title');
$jobListMessage    = get_field('job_list_message');
$jobListMessageURL = get_field('job_list_message_url');
$leg = ppj\LegNav\legName();
$jobAlertHTML = '';

/**
 * The Job Alert is some bespoke functionality that was commissioned so that during a period of time
 * (at the time of writing 1st - 15th of October)
 * when there will be significantly reduced jobs available on the site,
 * users who visit the 'find a job' page will have the opportunity to supply their email address
 * such that they can be contacted at a point in the future
 * when there are more jobs available.
 */

// If the job alert is active and the activate date has been set, continue.
// Otherwise do not try to display the job alert.
/* OLD code where active date was set - keeping for now  - need to discuss**/
/*
if ((bool)get_field('job_alert_active') && $activateDateString = get_field('job_alert_activate_date')) {
    // Explicitly set the time zone.
    // This will account for daylight savings.
    $timeZone = new DateTimeZone('Europe/London');

    // Get the current time as a DateTime object
    $now = new DateTime('now', $timeZone);

    // Create a DateTime object for when the Job Alert should be activated
    $activateDate = DateTime::createFromFormat('Y-m-d H:i:s', $activateDateString, $timeZone);

    // Compare the activate date to now, to determine if the JobAlert period has started
    if ($now->getTimestamp() > $activateDate->getTimestamp()) {
        // If the deactivate date has been set,
        // calculate if the Job Alert period has already ended
        // If it hasn't been set then assume the Job Alert period is active now.
        $ended = false;

        if ($deactivateDateString = get_field('job_alert_deactivate_date')) {
            $deactivateDate = DateTime::createFromFormat('Y-m-d H:i:s', $deactivateDateString, $timeZone);
            $ended          = $now->getTimestamp() > $deactivateDate->getTimestamp();
        }

        if (! $ended) {
            $jobAlertHTML = get_field('job_alert_text');
        }
    }
}*/

$jobsClosed = 0;

if ((bool)get_field('jobs_closed')){
    $jobsClosed = 1;
}
if ((bool)get_field('job_alert_active')){
    $jobAlertHTML = get_field('job_alert_text');
}


?>

<div class="find-a-job-container">

    <div class="job-alert-message">
        <p>A technical problem has led to some Prison officer vacancies incorrectly
            indicated as closed. <br>If this is the case, please check back after 24 hours. Thank you.</p>
    </div>
    <find-a-job job-title="<?= $jobTitle ?>"
                leg="<?= $leg ?>"
                jobs-closed="<?= $jobsClosed; ?>"
                job-list-message="<?= rawurlencode($jobListMessage) ?>"
                job-list-message-url="<?= $jobListMessageURL ?>"
    >
        <?php if ($jobAlertHTML) : ?>
            <template slot="jobAlertHTML"><?= $jobAlertHTML ?></template>
        <?php endif; ?>
    </find-a-job>

</div>

<?php include 'page-footer.php' ?>
