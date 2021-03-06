<?php

global $ppj_template_data;
$td = $ppj_template_data;
$groupStyle = (isset($group['style'])) ? "landing-page-groups__group--style-{$group['style']}" : '';

?>
<div class="l-full">
    <div class="landing-page-groups__container">
        <div class="landing-page-groups">
            <?php foreach($td['groups'] as $group): ?>
                <div class="landing-page-groups__group <?= $groupStyle ?>">
                    <div class="landing-page-groups__group-title-container">
                        <h3 class="landing-page-groups__group-title"><?= $group['group_name'] ?></h3>
                    </div>

                    <?php $numberOfCardsInRow = sizeof($group['cards']); ?>

                    <div class="landing-page-groups__card-row">
                        <?php foreach($group['cards'] as $card):
                            $cardHasImage = isset($card['image']['url']);
                            $cardClass = 'landing-page-groups__card';

                            $cardClasses  = $cardClass;
                            $cardClasses .= ($card['color']) ? ' ' . $cardClass . '--color-' . $card['color'] : '';
                            $cardClasses .= ($cardHasImage)  ? ' ' . $cardClass . '--has-image'               : '';

                            $cardLinkUrl = (isset($card['link']['url'])) ? $card['link']['url'] : '';

                            $cardImg = wp_get_attachment_image_src($card['image']['id'], $size = 'header-portrait-home');
                            $bgImgUrl = ($cardImg) ? $cardImg[0] : '';
                            ?>
                            <div class="<?= $cardClasses ?>">
                                <?php if($cardHasImage): ?>
                                    <div class="landing-page-groups__card-image-container">
                                        <div class="landing-page-groups__card-image-ratio-container">
                                            <div class="landing-page-groups__card-image-ratio">
                                                <a href="<?= $cardLinkUrl ?>"
                                                   class="landing-page-groups__card-link"
                                                   data-bg-img-url="<?= esc_attr($bgImgUrl) ?>"
                                                >

                                                    <?php echo wp_get_attachment_image(
                                                        $card['image']['id'],
                                                        '16:9x80',
                                                        false,
                                                        array(
                                                            "class" => "landing-page-groups__card-image",
                                                            "sizes" => "(min-width: 1440px) 640px, 480px",
                                                        )
                                                    ); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <h4 class="landing-page-groups__card-title"><?= $card['title'] ?></h4>

                                <div class="landing-page-groups__card-content"><?= $card['content'] ?></div>

                                <?php if ($cardLinkUrl): ?>
                                    <a class="landing-page-groups__card-cta-link"
                                       href="<?= $cardLinkUrl ?>"><?= $card['link']['title'] ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
