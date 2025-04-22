<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* D:\PERKULIAHAN\SEMESTER 6\Proyek Perangkat Lunak (Sukrina)\hrga\wintercms\themes\demo\layouts\default.htm */
class __TwigTemplate_81c76eb54858bfd51c9a2c82c0a1ad9b extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"utf-8\">
        <title>Winter CMS - ";
        // line 5
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["this"] ?? null), "page", [], "any", false, false, true, 5), "title", [], "any", false, false, true, 5), 5, $this->source), "html", null, true);
        yield "</title>
        <meta name=\"description\" content=\"";
        // line 6
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["this"] ?? null), "page", [], "any", false, false, true, 6), "meta_description", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
        yield "\">
        <meta name=\"title\" content=\"";
        // line 7
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->sandbox->ensureToStringAllowed(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["this"] ?? null), "page", [], "any", false, false, true, 7), "meta_title", [], "any", false, false, true, 7), 7, $this->source), "html", null, true);
        yield "\">
        <meta name=\"author\" content=\"Winter CMS\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"generator\" content=\"Winter CMS\">
        <link rel=\"icon\" type=\"image/png\" href=\"";
        // line 11
        yield $this->extensions['Cms\Twig\Extension']->themeFilter("assets/images/winter.png");
        yield "\">
        <link href=\"";
        // line 12
        yield $this->extensions['Cms\Twig\Extension']->themeFilter("assets/css/vendor.css");
        yield "\" rel=\"stylesheet\">
        <link href=\"";
        // line 13
        yield $this->extensions['Cms\Twig\Extension']->themeFilter("assets/css/theme.css");
        yield "\" rel=\"stylesheet\">
        ";
        // line 14
        echo $this->env->getExtension('Cms\Twig\Extension')->assetsFunction('css');
        echo $this->env->getExtension('Cms\Twig\Extension')->displayBlock('styles');
        // line 15
        yield "    </head>
    <body>

        <!-- Header -->
        <header id=\"layout-header\">
            ";
        // line 20
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('Cms\Twig\Extension')->partialFunction("site/header"        , $context['__cms_partial_params']        , true        );
        unset($context['__cms_partial_params']);
        // line 21
        yield "        </header>

        <!-- Content -->
        <section id=\"layout-content\">
            ";
        // line 25
        echo $this->env->getExtension('Cms\Twig\Extension')->pageFunction();
        // line 26
        yield "        </section>

        <!-- Footer -->
        <footer id=\"layout-footer\">
            ";
        // line 30
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('Cms\Twig\Extension')->partialFunction("site/footer"        , $context['__cms_partial_params']        , true        );
        unset($context['__cms_partial_params']);
        // line 31
        yield "        </footer>

        <!-- Scripts -->
        <script src=\"";
        // line 34
        yield $this->extensions['Cms\Twig\Extension']->themeFilter("assets/vendor/jquery.js");
        yield "\"></script>
        <script src=\"";
        // line 35
        yield $this->extensions['Cms\Twig\Extension']->themeFilter("assets/vendor/bootstrap.js");
        yield "\"></script>
        <script src=\"";
        // line 36
        yield $this->extensions['Cms\Twig\Extension']->themeFilter("assets/javascript/app.js");
        yield "\"></script>
        ";
        // line 37
        $_minify = System\Classes\CombineAssets::instance()->useMinify;
        echo '<script data-module="snowboard-manifest" src="http://127.0.0.1:8000/modules/system/assets/js/build/manifest.js?v=1.2.7"></script>'.PHP_EOL;
        echo '<script data-module="snowboard-vendor" src="http://127.0.0.1:8000/modules/system/assets/js/snowboard/build/snowboard.vendor.js?v=1.2.7"></script>'.PHP_EOL;
        echo '<script data-module="snowboard-base" data-base-url="http://127.0.0.1:8000/" data-asset-url="http://127.0.0.1:8000/" src="http://127.0.0.1:8000/modules/system/assets/js/snowboard/build/snowboard.base.js?v=1.2.7"></script>'.PHP_EOL;
        echo '<script data-module="request" src="http://127.0.0.1:8000/modules/system/assets/js/snowboard/build/snowboard.request.js?v=1.2.7"></script>'.PHP_EOL;
        echo '<script data-module="attr" src="http://127.0.0.1:8000/modules/system/assets/js/snowboard/build/snowboard.data-attr.js?v=1.2.7"></script>'.PHP_EOL;
        echo '<script data-module="extras" src="http://127.0.0.1:8000/modules/system/assets/js/snowboard/build/snowboard.extras.js?v=1.2.7"></script>'.PHP_EOL;
        // line 38
        yield "        ";
        echo $this->env->getExtension('Cms\Twig\Extension')->assetsFunction('js');
        echo $this->env->getExtension('Cms\Twig\Extension')->assetsFunction('vite');
        echo $this->env->getExtension('Cms\Twig\Extension')->displayBlock('scripts');
        // line 39
        yield "
    </body>
</html>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "D:\\PERKULIAHAN\\SEMESTER 6\\Proyek Perangkat Lunak (Sukrina)\\hrga\\wintercms\\themes\\demo\\layouts\\default.htm";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  139 => 39,  134 => 38,  126 => 37,  122 => 36,  118 => 35,  114 => 34,  109 => 31,  105 => 30,  99 => 26,  97 => 25,  91 => 21,  87 => 20,  80 => 15,  77 => 14,  73 => 13,  69 => 12,  65 => 11,  58 => 7,  54 => 6,  50 => 5,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"utf-8\">
        <title>Winter CMS - {{ this.page.title }}</title>
        <meta name=\"description\" content=\"{{ this.page.meta_description }}\">
        <meta name=\"title\" content=\"{{ this.page.meta_title }}\">
        <meta name=\"author\" content=\"Winter CMS\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"generator\" content=\"Winter CMS\">
        <link rel=\"icon\" type=\"image/png\" href=\"{{ 'assets/images/winter.png'|theme }}\">
        <link href=\"{{ 'assets/css/vendor.css'|theme }}\" rel=\"stylesheet\">
        <link href=\"{{ 'assets/css/theme.css'|theme }}\" rel=\"stylesheet\">
        {% styles %}
    </head>
    <body>

        <!-- Header -->
        <header id=\"layout-header\">
            {% partial 'site/header' %}
        </header>

        <!-- Content -->
        <section id=\"layout-content\">
            {% page %}
        </section>

        <!-- Footer -->
        <footer id=\"layout-footer\">
            {% partial 'site/footer' %}
        </footer>

        <!-- Scripts -->
        <script src=\"{{ 'assets/vendor/jquery.js'|theme }}\"></script>
        <script src=\"{{ 'assets/vendor/bootstrap.js'|theme }}\"></script>
        <script src=\"{{ 'assets/javascript/app.js'|theme }}\"></script>
        {% snowboard all %}
        {% scripts %}

    </body>
</html>", "D:\\PERKULIAHAN\\SEMESTER 6\\Proyek Perangkat Lunak (Sukrina)\\hrga\\wintercms\\themes\\demo\\layouts\\default.htm", "");
    }
    
    public function checkSecurity()
    {
        static $tags = ["styles" => 14, "partial" => 20, "page" => 25, "snowboard" => 37, "scripts" => 38];
        static $filters = ["escape" => 5, "theme" => 11];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['styles', 'partial', 'page', 'snowboard', 'scripts'],
                ['escape', 'theme'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
