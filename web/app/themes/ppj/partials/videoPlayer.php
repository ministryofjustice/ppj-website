<?php

global $ppj_template_data;
$td = $ppj_template_data;

?>

<div class="video-player video-player--<?= $td['host'] ?>"
     id="<?= $td['id'] ?>"
>
    <?php if ($td['cover-image-id']):
        $coverImage = wp_get_attachment_image(
            $td['cover-image-id'],
            '16:9x80',
            false,
            [
                'class' => 'video-player__cover-image',
                'sizes' => '(min-width: 1440px) 792px, (min-width: 1024px) 915px, (max-width: 768px) calc((100vw - 64px) * 0.75), 0.85vw'
            ]
        );
        /**
         * As the play button SVG might be used multiple times on a page
         * each instance should have a unique ID.
         * This is for accessibility concerns (e.g. supporting screen readers)
         * and also for good HTML semantics.
         *
         * The `uniqid` function is being used to create a unique string
         * that is appended to the standard ID values
         */
        $uniqueSuffix = uniqid(null, true);
        $uniqueAriaTitleId =  'playButtonIconTitle_' . $uniqueSuffix;
        $uniqueAriaDescId =  'playButtonIconDesc_' . $uniqueSuffix;
        $ariaLabelledBy = "{$uniqueAriaTitleId} {$uniqueAriaDescId}";
        ?>
        <a aria-label="Play Video"
           class="video-player__cover"
           href="#"
        >
            <?php echo $coverImage ?>
            <div class="video-player__play-button-container">
                <svg
                    aria-labelledby="<?= $ariaLabelledBy ?>"
                    class="video-player__play-button"
                     x="0px"
                     y="0px"
                     viewBox="0 0 138.3 138.3"
                     style="enable-background:new 0 0 138.3 138.3;"
                     role="img"
                >
                    <title id="<?= $uniqueAriaTitleId ?>">Play button icon</title>
                    <desc id="<?= $uniqueAriaDescId ?>">A white triangle pointing to the right, within a circle</desc>
                    <path class="st0" d="M69.2,8c33.7,0,61.2,27.4,61.2,61.2s-27.4,61.2-61.2,61.2S8,102.9,8,69.2S35.4,8,69.2,8 M69.2,0
                C31,0,0,31,0,69.2s31,69.2,69.2,69.2s69.2-31,69.2-69.2S107.4,0,69.2,0L69.2,0z"/>
                    <polygon class="st0" points="96.3,69.2 48.4,41.5 48.4,96.8 96.3,69.2 48.4,41.5 48.4,96.8 "/>
                </svg>
            </div>
        </a>
    <?php endif; ?>
     <div class="video-player__video-container">
         <?php if ($td['host'] == 'wistia'): ?>
             <div class="wistia_embed wistia_async_<?= $td['id'] ?>"></div>
         <?php endif; ?>

         <?php if ($td['host'] == 'raptmedia'): ?>
             <iframe
                  src='https://cdn1.raptmedia.com/projects/<?= $td['id'] ?>/embed?autoplay=false&controls=below'
                  allowtransparency="true"
                  frameborder="0"
                  scrolling="no"
                  allowfullscreen
                  mozallowfullscreen
                  webkitallowfullscreen
                  oallowfullscreen
                  msallowfullscreen
             ></iframe>
         <?php endif; ?>
   </div>
</div>
