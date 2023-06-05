![](src/Resources/config/poc-shopware-6.jpg)

# Shopware 6 Related Products Carousel Plugin

After the plugin installation, you can have related products end of the product details page.

![](src/Resources/config/related_products_carousel.jpg)
*Related products carousel*

### Configuration

If you are using a specific plugin theme, just put this block at the end of the ` {% block page_product_detail %}` block in the
`Resources\views\storefront\page\product-detail\index.html.twig` file:


### Block

<pre>
{% block sw_cms_element_simillar_product %}
    {% if page.product.customFields['similarProduct'] %}
        {% set productElements =page.product.customFields['similarProduct'] %}
            {% block block_product_slider_inner %}
                {% sw_include "@Storefront/storefront/element/cms-element-simillar-product.html.twig" ignore missing %}
            {% endblock %}
        {% endif %}
  {% endblock %}
</pre>

### Example
<pre>
{% sw_extends '@Storefront/storefront/page/product-detail/index.html.twig' %}

{% block base_head %}
    {{ parent() }}
{% endblock %}

{% block base_content %}

    {% block page_product_detail %}
        {{ parent() }}
    {% endblock %}

    {% block sw_cms_element_simillar_product %}

        {% if page.product.customFields['similarProduct'] %}
            {% set productElements =page.product.customFields['similarProduct'] %}
            {% block block_product_slider_inner %}
                {% sw_include "@Storefront/storefront/element/cms-element-simillar-product.html.twig" ignore missing %}
            {% endblock %}
        {% endif %}

    {% endblock %}
{% endblock %}

</pre>

![](src/Resources/config/related_products_carousel_1.jpg)
