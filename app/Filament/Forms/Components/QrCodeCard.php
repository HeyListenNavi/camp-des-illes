<?php

namespace App\Filament\Forms\Components;

use App\Services\QrCodeService;
use Filament\Forms\Components\Field;

class QrCodeCard extends Field
{
    protected string $view = 'filament.forms.components.qr-code-card';

    protected string|\Closure|null $url = null;

    protected string|\Closure|null $caption = null;

    protected int $qrSize = 140;

    public static function make(?string $name = null): static
    {
        $static = parent::make($name);
        $static->dehydrated(false);

        return $static;
    }

    public function url(string|\Closure|null $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function caption(string|\Closure|null $caption): static
    {
        $this->caption = $caption;

        return $this;
    }

    public function qrSize(int $size): static
    {
        $this->qrSize = $size;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->evaluate($this->url);
    }

    public function getCaption(): ?string
    {
        return $this->evaluate($this->caption);
    }

    public function getQrSvg(): ?string
    {
        $url = $this->getUrl();

        if (empty($url)) {
            return null;
        }

        return QrCodeService::generateSvgString($url, $this->qrSize);
    }
}
