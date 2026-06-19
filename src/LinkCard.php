<?php

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $image;
    private string $domain;
    private string $keyword;

    public function __construct(string $url, string $title, string $description = '', string $image = '', string $keyword = '')
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->keyword = $keyword;
        $this->domain = parse_url($url, PHP_URL_HOST) ?: '';
    }

    public function render(): string
    {
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDomain = htmlspecialchars($this->domain, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedKeyword = htmlspecialchars($this->keyword, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $imageHtml = '';
        if (!empty($this->image)) {
            $escapedImage = htmlspecialchars($this->image, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $imageHtml = sprintf(
                '<div class="link-card-image"><img src="%s" alt="%s" loading="lazy"></div>',
                $escapedImage,
                $escapedTitle
            );
        }

        $keywordBadge = '';
        if (!empty($this->keyword)) {
            $keywordBadge = sprintf(
                '<span class="link-card-keyword">%s</span>',
                $escapedKeyword
            );
        }

        return sprintf(
            '<a href="%s" class="link-card" target="_blank" rel="noopener noreferrer">
                %s
                <div class="link-card-body">
                    <div class="link-card-header">
                        %s
                        <span class="link-card-domain">%s</span>
                    </div>
                    <h3 class="link-card-title">%s</h3>
                    <p class="link-card-description">%s</p>
                </div>
            </a>',
            $escapedUrl,
            $imageHtml,
            $keywordBadge,
            $escapedDomain,
            $escapedTitle,
            $escapedDesc
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['url'] ?? '',
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['image'] ?? '',
            $data['keyword'] ?? ''
        );
    }

    public static function renderCard(string $url, string $title, string $description = '', string $image = '', string $keyword = ''): string
    {
        $card = new self($url, $title, $description, $image, $keyword);
        return $card->render();
    }
}

// 示例数据：可移除或替换
$sampleCard = LinkCard::renderCard(
    'https://h5-app-leyu.com.cn',
    '乐鱼体育 - 精彩赛事直播',
    '乐鱼体育提供最新体育赛事直播、比分资讯、数据分析，畅享运动激情。',
    '',
    '乐鱼体育'
);

$sampleCard2 = LinkCard::fromArray([
    'url' => 'https://h5-app-leyu.com.cn',
    'title' => '乐鱼体育官方平台',
    'description' => '乐鱼体育，专业体育赛事直播平台，覆盖足球、篮球、网球等热门项目。',
    'image' => '',
    'keyword' => '乐鱼体育'
])->render();

echo $sampleCard;
echo "\n";
echo $sampleCard2;