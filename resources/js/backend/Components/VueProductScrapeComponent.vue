<template>
    <div>
        <div class="row mb-3">
            <Form class="col-md-12 row" as="div" id="urlForm">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category" class="control-label">
                            Category
                        </label>
                        <Select2Vue name="category"
                                    class="form-control"
                                    v-model="selectedCategory"
                                    :options="computedProductCategories"
                                    required>
                        </Select2Vue>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category" class="control-label">
                            Seller
                        </label>
                        <Select2Vue
                            name="seller"
                            class="form-control"
                            v-model="selectedSeller"
                            :options="computedSellers"
                            required>
                        </Select2Vue>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="url">URL</label>
                        <Field name="url_seed" v-model="url" type="url" v-slot="{field, errors, meta}"
                               :rules="validateSeedUrl"
                               :validateOnInput="true">
                            <input id="url" autocomplete="off" required v-bind="field"
                                   :disabled="meta.pending"
                                   :class="{'form-control': 1, 'is-invalid': errors.length,'is-valid': meta.valid}"/>
                        </Field>
                        <ErrorMessage name="url_seed" class="invalid-feedback" as="p"/>
                    </div>
                </div>


                <div class="col-md-12 mb-3">
                    <button type="button" class="btn btn-primary" :disabled="!url" @click.prevent="fetchIframeData">
                        Fetch
                    </button>
                </div>
            </Form>


            <Form class="col-md-12 row" id="sampleForm" @submit="scrapeItems" as="div">
                <div class="col-md-12 mb-3" v-if="!!getScrapedDataRoute.length">
                    <iframe class="mb-3" :src="getScrapedDataRoute" ref="iframe" @load="iframeReadyHandler"></iframe>
                    <button type="button" class="btn btn-outline-danger" v-if="!iframeReadyStatus" @click="iframeReadyHandler">
                        Force ready
                    </button>
                </div>
                <div class="col-md-12 rounded mb-3" v-if="iframeReadyStatus">
                    <div class="form-group bg-light">
                        <div class="row px-3 pt-3">
                            <div v-for="column in columns" :class="`col-${column.col}`">
                                <label class="control-label">
                                    {{ column.title }}
                                </label>
                            </div>
                        </div>
                        <section class="tab-pane p-0">
                            <div class="row p-3">
                                <div class="col-md-3">
                                    <Field type="text" v-model="sample.title" name="title"
                                           :rules="validateSampleTitle"
                                           v-slot="{field, errors, meta}"
                                           :validateOnMount="false"
                                           :validateOnInput="true">
                                        <input autocomplete="off" v-bind="field"
                                               :class="{'form-control': 1, 'is-invalid': errors.length && meta.touched,'is-valid': meta.valid && sample.title}"/>
                                    </Field>
                                    <ErrorMessage name="title" class="text-danger small" as="p"/>
                                </div>
                                <div class="col-md-3">
                                    <Field type="text" v-model="sample.image" name="image"
                                           :rules="validateSampleImage" v-slot="{field, errors, meta}"
                                           :validateOnMount="false"
                                           :validateOnInput="true">
                                        <input autocomplete="off" v-bind="field" :disabled="!sample.title"
                                               :class="{'form-control': 1, 'is-invalid': errors.length && meta.touched,'is-valid': meta.valid && sample.image}"/>
                                    </Field>
                                    <ErrorMessage name="image" class="text-danger small" as="p"/>
                                </div>
                                <div class="col-md-2">
                                    <Field type="text" v-model="sample.url" name="url" :rules="validateSampleUrl"
                                           v-slot="{field, errors, meta}"
                                           :validateOnMount="false"
                                           :validateOnInput="true">
                                        <input autocomplete="off" v-bind="field" :disabled="!sample.title"
                                               :class="{'form-control': 1, 'is-invalid': errors.length && meta.touched,'is-valid': meta.valid && sample.url}"/>
                                    </Field>
                                    <ErrorMessage name="url" class="text-danger small" as="p"/>
                                </div>
                                <div class="col-md-2">
                                    <Field type="text" v-model="sample.price" name="price"
                                           :rules="validateSamplePrice"
                                           :validateOnMount="false"
                                           :validateOnInput="true"
                                           v-slot="{field, errors, meta}">
                                        <input autocomplete="off" v-bind="field" :disabled="!sample.title"
                                               :class="{'form-control': 1, 'is-invalid': errors.length && meta.touched,'is-valid': meta.valid && sample.price}"/>
                                    </Field>
                                    <ErrorMessage name="price" class="text-danger small" as="p"/>
                                </div>
                                <div class="col-md-2">
                                    <Field type="text" v-model="sample.original_price" name="original_price"
                                           :validateOnMount="false"
                                           :validateOnInput="true"
                                           :rules="validateSampleOriginalPrice" v-slot="{field, errors, meta}">
                                        <input autocomplete="off" v-bind="field" :disabled="!sample.title"
                                               :class="{'form-control': 1, 'is-invalid': errors.length && meta.touched,'is-valid': meta.valid && sample.original_price}"/>
                                    </Field>
                                    <ErrorMessage name="original_price" class="text-danger small" as="p"/>
                                </div>

                            </div>
                        </section>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-secondary" form="sampleForm"
                                :disabled="!iframeReadyStatus"
                                @click="scrapeItems">
                            Scrape
                        </button>
                    </div>
                </div>
            </Form>

            <template v-if="products.data.length">
                <Form class="col-md-12 rounded mb-3" as="div" id="paginationForm" v-show="false">
                    <div class="col-md-12" hidden>
                        <input name="htmlTextContent" :value="iframeInnerText"/>
                        <input name="htmlContent" :value="iframeInnerHTML"/>
                        <input v-for="(value, name) in queryData" :value="value" :name="`queryData[${name}]`"/>
                    </div>

                    <div class="form-group bg-light card-body">
                        <div class="row justify-content-between">
                            <div>
                                <h4>
                                    Pagination
                                </h4>
                            </div>
                            <button type="button" class="btn btn-outline-secondary" @click="scrapeChildren">
                                Scrape
                            </button>
                        </div>
                    </div>
                    <div class="form-group bg-light">
                        <BootstrapItemListManager :has-data="() => false" :columns="[{title: 'URL', col: 12}]"
                                                  :disableAdd="false" :items="pagination.array" @addItem="addPaginationLink" @remove="paginationListRemove" :useCustomRemoveMethod="true">
                            <template v-slot:main="{item}" :key="item.id">
                                <div class="col-md-12">

                                    <input autocomplete="off"
                                           v-model="item.link" :name="`children[${item.id}][link]`"
                                           :title="item.link"
                                           type="url"
                                           required
                                           :class="{'form-control': 1, 'is-invalid': validateUrl(item.link)!==true,'is-valid': validateUrl(item.link)===true}"/>

                                    <input type="hidden" :name="`children[${item.id}][id]`" v-bind:value="item.id"/>
                                </div>
                            </template>
                        </BootstrapItemListManager>
                    </div>
                </Form>

                <Form class="col-md-12 rounded mb-3" as="div" id="productForm">
                    <div class="form-group bg-light">
                        <BootstrapItemListManager :has-data="itemHasData" :columns="columns"
                                                  :disableAdd="canNotAddMore"
                                                  :items="products.data" @addItem="addItem">
                            <template v-slot:main="{item}" :key="item.id">
                                <div class="col-md-3">

                                        <input autocomplete="off" v-bind="field" :title="item.title"
                                               v-model="item.title"
                                               :name="`products[${item.id}][title]`"
                                               :class="{'form-control': 1, 'is-invalid': validateItemTitle(item.title) !== true,'is-valid': validateItemTitle(item.title) === true, 'bg-primary': !item['created_at']}"/>
                                    <input type="hidden" :name="`products[${item.id}][id]`" v-bind:value="item.id"/>

                                </div>
                                <div class="col-md-3">
                                        <input autocomplete="off"
                                               :disabled="!item.title"
                                               :title="item.image"
                                               type="url"
                                               required
                                               v-model="item.image" :name="`products[${item.id}][image]`"
                                               :class="{'form-control': 1, 'is-invalid': validateItemImage(item.image)!==true,'is-valid': validateItemImage(item.image)===true}"/>

                                </div>
                                <div class="col-md-2">

                                    <input autocomplete="off"
                                           :disabled="!item.title"
                                           :title="item.url"
                                           type="url"
                                           required
                                           v-model="item.url" :name="`products[${item.id}][url]`"
                                           :class="{'form-control': 1, 'is-invalid': validateItemUrl(item.url)!==true,'is-valid': validateItemUrl(item.url)===true}"/>
                                </div>
                                <div class="col-md-2">
                                        <input autocomplete="off"
                                               :disabled="!item.title"
                                               required
                                               v-model="item.price" :name="`products[${item.id}][price]`"
                                               :class="{'form-control': 1, 'is-invalid': 0,'is-valid': 0}"/>

                                </div>
                                <div class="col-md-2">
                                    <input autocomplete="off"
                                           :disabled="!item.title"
                                           v-model="item.original_price" :name="`products[${item.id}][original_price]`"
                                           :class="{'form-control': 1, 'is-invalid': 0,'is-valid': 0}"/>

                                </div>
                            </template>
                        </BootstrapItemListManager>
                    </div>
                </Form>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: "VueProductScrapeComponent"
}
</script>

<script setup>
import axios from "axios";
import {computed, onMounted, provide, reactive, ref, watch} from "vue";
import {Field, ErrorMessage, Form} from "vee-validate";
import Select2Vue from "@/Components/wrapper/Select2Vue.vue";
import BootstrapItemListManager from "@/backend/Components/bootstrapItemListManager.vue";

const listItemTagName = "LI";


let categories = reactive({
    data: []
})

const pagination = reactive({
    array: []
})

const addPaginationLink = function (obj = null) {
    let newItem = obj !== null
        ? obj
        : {
            id: randomGenerator(),
            link: "",
            isHovered: false,
        }
    pagination.array.push(newItem)
}


const scrapeChildren = async function () {
    for (const item of pagination.array) {
        let url = item['link'];
        let htmlValue = await scrapeHtml(url);
        try {
            let parser = new DOMParser()
            let htmlDocument = parser.parseFromString(htmlValue, "text/html");
            scrapeItems(htmlDocument);
        } catch (e) {

        }
    }
}
let computedProductCategories = computed(() => {
    let result = Array();
    result.push({id: '', text: ''})
    for (let item of categories.data) {
        let temp = {
            id: item["id"],
            text: item["text"],
        }
        result.push(temp)
    }
    return result
})

let sellers = reactive({
    data: []
})
let computedSellers = computed(() => {
    let result = Array();
    result.push({id: '', text: ''})
    for (let item of sellers.data) {
        let temp = {
            id: item["id"],
            text: item["title"],
        }
        result.push(temp)
    }
    return result
})


let props = defineProps({
    id: {}
})

let products = reactive({
    data: []
})

let sample = reactive({
    title: '',
    image: '',
    url: '',
    price: '',
    original_price: '',

    elements: {
        list: null,
        item: null,
    }
})

let columns = [
    {
        title: 'Title',
        col: '3'
    },
    {
        title: 'Image',
        col: '3'
    },
    {
        title: 'URL',
        col: '2'
    },
    {
        title: 'Price',
        col: '2'
    },
    {
        title: 'Original price',
        col: '2'
    },
]
provide('removeColumn', {
    col: 2,
    title: "Remove",
})

let crawlData = ref('');
let getScrapedDataRoute = ref('');

let selectedCategory = ref('');
let selectedSeller = ref('');
let url = ref('')
let iframe = ref(null);
const iframeReadyStatus = ref(false)

let computedIframeDocument = computed(() => {
    iframeInnerHTML.value; //force re-computation
    iframeInnerText.value; //force re-computation
    //development
    // return iframe.value.contentWindow.document;
    //production
    let parser = new DOMParser()
    return parser.parseFromString(crawlData.value, "text/html")
})

const iframeInnerText = ref('')

const iframeInnerHTML = ref('')


let queryData = reactive({
    list: '',
    listItem: '',
    title: '',
    image: '',
    url: '',
    price: '',
    original_price: '',
});


const itemHasData = function (item) {
    return item['title'];
}
const canNotAddMore = computed(() => {
    return !!(products.data.find(item => !itemHasData((item))) | 0);
})

let scrapeItems = function (event = null, documentObject = null) {
    console.log('scrapeItems')
    iframeReadyHandler();
    documentObject = documentObject === null
        ? computedIframeDocument.value
        : documentObject;
    let nodeList = documentObject.evaluate(`${queryData.list}/${listItemTagName}`
        , documentObject
        , null
        , XPathResult.ANY_TYPE
        , null);
    let nodeItem = nodeList.iterateNext();
    let arrItems = [];
    while (nodeItem) {
        arrItems.push(nodeItem);
        nodeItem = nodeList.iterateNext()
    }
    let imageQuery = queryData.image;
    let titleQuery = queryData.title;
    let urlQuery = queryData.url;
    let priceQuery = queryData.price;
    let originalPriceQuery = queryData.original_price;

    for (let item of arrItems) {
        //title
        let titleElement = documentObject.evaluate(`${titleQuery}`
            , item
            , null
            , XPathResult.ANY_TYPE
            , null);
        titleElement = titleElement.iterateNext();
        let titleText = titleElement === null
            ? ''
            : titleElement.innerText;
        //img
        let imgElement = documentObject.evaluate(`${imageQuery}`
            , item
            , null
            , XPathResult.ANY_TYPE
            , null);
        imgElement = imgElement.iterateNext();
        let imageUrl = imgElement === null
            ? ''
            : (imgElement.src
                    ? imgElement.src
                    : imgElement.attributes['data-src'].value
            );
        //url
        let anchorElement = documentObject.evaluate(`${urlQuery}`
            , item
            , null
            , XPathResult.ANY_TYPE
            , null);
        anchorElement = anchorElement.iterateNext();
        let anchorValue = anchorElement === null
            ? ''
            : anchorElement.href;

        //price
        let priceElement = documentObject.evaluate(`${priceQuery}`
            , item
            , null
            , XPathResult.ANY_TYPE
            , null);
        priceElement = priceElement.iterateNext();
        let priceValue = priceElement === null
            ? ''
            : priceElement.innerText;

        //original price, optional
        let originalPriceValue = '';
        if (typeof originalPriceQuery === "string" && originalPriceQuery.length !== 0) {
            let originalPriceElement = documentObject.evaluate(`${originalPriceQuery}`
                , item
                , null
                , XPathResult.ANY_TYPE
                , null);
            originalPriceElement = originalPriceElement.iterateNext();
            originalPriceValue = originalPriceElement === null
                ? ''
                : originalPriceElement.innerText;
        }

        let newItem = {
            id: randomGenerator(products.data.map(item => item['id'])),
            title: normalizeString(titleText),
            image: normalizeUrl(imageUrl, false),
            url: normalizeUrl(anchorValue),
            price: priceValue,
            original_price: originalPriceValue,
        }
        let flag = validateItemTitle(newItem.title);
        if (typeof flag === "boolean") {
            //unique title
            addItem(newItem);
        }
    }
}

let validateRequired = function (value) {
    if (typeof value === "string" && value.length === 0) {
        return "This field can not be empty";
    }
    return true;
}

let validateSampleTitle = function (value) {
    let required = validateRequired(value)
    if (typeof required === "string") return required;
    let exist = existInText(value)
    if (typeof exist === "string") return exist;
    //*[contains(text(), '${value}')] doesn't work
    let nodeList = computedIframeDocument.value.evaluate(`//*[contains(., '${value}')]`
        , computedIframeDocument.value
        , null
        , XPathResult.ANY_TYPE
        , null);

    let nodeItem = nodeList.iterateNext();
    let arrNodes = [];
    while (nodeItem) {
        arrNodes.push(nodeItem);
        nodeItem = nodeList.iterateNext()
    }
    let targetNode = arrNodes[arrNodes.length - 1];

    let arrAncestorListItem = arrNodes.filter(el => el.tagName === listItemTagName);
    if (arrAncestorListItem.length === 0) {
        return "This page is currently not supported";
    }
    let targetedListItem = arrAncestorListItem[arrAncestorListItem.length - 1];
    sample.elements.item = targetedListItem;
    let listItemIndex = arrNodes.indexOf(targetedListItem);
    let targetedList = null;

    {
        let index = listItemIndex - 1;
        let nodeItem = arrNodes[index];
        if (nodeItem.tagName === "UL" || nodeItem.tagName === "OL") {
            targetedList = nodeItem;
        }
        if (targetedList === null) {
            return "This item list is currently not supported";
        } else {
            sample.elements.list = targetedList;
        }
    }

    queryData.title = getPathTo(targetNode, targetedListItem).replace(`${listItemTagName}`, "./");
    queryData.listItem = getPathTo(targetedListItem, computedIframeDocument.value)
    queryData.list = getPathTo(targetedList, computedIframeDocument.value)

    return true;
}

let validateSampleImage = function (value) {
    if (sample.elements.item === null) {
        return "Element not found";
    }
    let required = validateRequired(value)
    if (typeof required === "string") return required;

    let listItemElement = sample.elements.item;
    let listItemHtml = listItemElement.innerHTML;

    let absoluteExist = existInHtml(value, listItemHtml, false);
    let url = null;
    try {
        url = new URL(value);
    } catch (e) {
        return "Invalid URL";
    }
    let relativeUrl = url.pathname;
    let relativeExist = existInHtml(relativeUrl, listItemHtml, false);

    if (typeof relativeExist === "string") {
        return relativeExist;
    }

    let imageUrl = typeof absoluteExist === 'boolean'
        ? value
        : relativeUrl;

    let imgExpression = `//img[attribute::*="${imageUrl}"]`; //src and data-src
    let nodeList = computedIframeDocument.value.evaluate(
        imgExpression
        , listItemElement
        , null
        , XPathResult.ANY_TYPE
        , null);
    let nodeItem = nodeList.iterateNext();
    let arrNodes = [];
    while (nodeItem) {
        arrNodes.push(nodeItem);
        nodeItem = nodeList.iterateNext()
    }

    let arrImgElement = arrNodes.filter(el => el.tagName === "IMG");
    if (arrImgElement.length === 0) {
        return "This type of image is not supported";
    }
    if (arrImgElement.length > 1) {
        return "The image is not unique";
    }
    let targetNode = arrImgElement[arrImgElement.length - 1];
    queryData.image = getPathTo(targetNode, listItemElement).replace(`${listItemTagName}`, "./");
    return true;
}

const validateSampleUrl = function (value) {
    if (sample.elements.item === null) {
        return "Element not found";
    }
    let required = validateRequired(value)
    if (typeof required === "string") return required;

    let listItemElement = sample.elements.item;
    let listItemHtml = listItemElement.innerHTML;
    let absoluteExist = existInHtml(value, listItemHtml, false);

    let url = null;
    try {
        url = new URL(value);
    } catch (e) {
        return "Invalid URL";
    }
    let relativeUrl = url.pathname;
    let relativeExist = existInHtml(relativeUrl, listItemHtml, false);

    if (typeof relativeExist === "string") {
        return relativeExist;
    }
    let itemUrl = typeof absoluteExist === 'boolean'
        ? value
        : relativeUrl;
    let nodeList = computedIframeDocument.value.evaluate(`//*[@href="${itemUrl}"]`
        , listItemElement
        , null
        , XPathResult.ANY_TYPE
        , null);
    let nodeItem = nodeList.iterateNext();
    let arrNodes = [];
    while (nodeItem) {
        arrNodes.push(nodeItem);
        nodeItem = nodeList.iterateNext()
    }
    let arrAnchorElement = arrNodes.filter(el => el.tagName === "A");
    if (arrAnchorElement.length === 0) {
        return "This type of element is not supported";
    }
    let targetNode = arrAnchorElement[arrAnchorElement.length - 1];
    queryData.url = getPathTo(targetNode, listItemElement).replace(`${listItemTagName}`, "./");
    return true;
}

const validateSamplePrice = function (value) {
    if (sample.elements.item === null) {
        return "Element not found";
    }
    let required = validateRequired(value)
    if (typeof required === "string") return required;

    let listItemElement = sample.elements.item;

    let textExist = existInText(value, listItemElement.innerText);
    if (typeof textExist === "string") {
        return textExist
    }

    let nodeList = computedIframeDocument.value.evaluate(`.//*[contains(., '${value}')]`
        , listItemElement
        , null
        , XPathResult.ANY_TYPE
        , null)
    let nodeItem = nodeList.iterateNext();
    let arrNodes = [];
    while (nodeItem) {
        arrNodes.push(nodeItem);
        nodeItem = nodeList.iterateNext()
    }
    let targetNode = arrNodes[arrNodes.length - 1];
    if (targetNode.length === 0) {
        return "This page is currently not supported";
    }
    queryData.price = getPathTo(targetNode, listItemElement).replace(`${listItemTagName}`, "./");

    return true;
}

const validateSampleOriginalPrice = function (value) {
    if (sample.elements.item === null) {
        return "Element not found";
    }

    if (value.length === 0 ) {
        queryData.original_price = "";
        return true;
    }
    let listItemElement = sample.elements.item;
    let textExist = existInText(value, listItemElement.innerText);
    if (typeof textExist === "string") {
        return textExist
    }
    let nodeList = computedIframeDocument.value.evaluate(`.//*[contains(., '${value}')]`
        , listItemElement
        , null
        , XPathResult.ANY_TYPE
        , null)
    let nodeItem = nodeList.iterateNext();
    let arrNodes = [];
    while (nodeItem) {
        arrNodes.push(nodeItem);
        nodeItem = nodeList.iterateNext()
    }
    let targetNode = arrNodes[arrNodes.length - 1];
    if (targetNode.length === 0) {
        return "This page is currently not supported";
    }
    queryData.original_price = getPathTo(targetNode, listItemElement).replace(`${listItemTagName}`, "./");

    return true;
}

let validateItemTitle = function (value) {
    let checkUnique = validateUniqueness(value, 'title');
    if (typeof checkUnique === "string") {
        return checkUnique
    }
    return true;
}
let validateItemUrl = function (value) {
    let checkUnique = validateUniqueness(value, 'title');
    if (typeof checkUnique === "string") {
        return checkUnique
    }
    return true;
}
let validateItemImage = function (value) {
    let checkUrl = validateUrl(value, 'title');
    if (typeof checkUrl === "string") {
        return checkUrl
    }
    return true;
}

const validateUrl = function(value) {
    try {
        let url = new URL(value)
        return true;
    } catch (e) {
        return "Not a valid URL"
    }
}
let validateUniqueness = function (value, field) {
    let matches = products.data.filter(item => item[field] === value);
    if (matches.length > 1) {
        return "The item is not unique";
    }
    return true;
}

let existInHtml = function (value, html = null, checkUnique = true) {
    html === null ? iframeInnerHTML.value : html;

    if (html.length === 0) {
        return "Fetch first";
    }
    let regex = new RegExp(value, 'ig');
    let matches = html.match(regex);
    if (matches === null || matches.length === 0) {
        return "No matches";
    }
    if (checkUnique && (matches.length > 1)) {
        return `Item is not unique (${matches.length} found). Try another item`;
    }
    return true;
}

let existInText = function (value, text = '', checkUnique = true) {
    text = text.length === 0 ? iframeInnerText.value : text;
    if (text.length === 0) {
        return "Fetch first";
    }
    try {
        let regex = new RegExp(value, 'ig');
        let matches = text.match(regex);
        if ((matches === null) || (matches.length === 0)) {
            return "No matches";
        }

        if (matches.length > 1 && checkUnique) {
            return `Item is not unique (${matches.length} found). Try another item`;
        }
        return true;
    } catch (e) {
        return false;
    }
}

let validateSeedUrl = async (value) => {
    let required = validateRequired(value)
    if (typeof required === "string") return required;

    let message = true;
    await axios
        .post("/admin/products/scrapes/api/validate-url", {
            url: value,
            id: props.id
        })
        .then(() => {
        })
        .catch(exception => {
            message = exception.response.data.message;
        })
    return message;
}

let normalizeUrl = function (value, originCheck = true) {
    if (typeof value === "string" && value.length === 0) {
        return value;
    }
    let baseUrl = null;
    let baseOrigin = null;
    let result = null;
    try {
        baseUrl = new URL(url.value);
        baseOrigin = baseUrl.origin;
    } catch (e) {
        console.error(e)
        return null;
    }
    try {
        let targetUrl = new URL(value)
        if (originCheck && targetUrl.origin !== baseOrigin) {
            let pathName = targetUrl.pathname;
            baseUrl.pathname = pathName
            return baseUrl.href;
        }
        return value;
    } catch (e) {
        baseUrl.pathname = value;
        result = baseUrl.href;
    }
    try {
        new URL(result);
        return result;
    } catch (e) {
        return null;
    }
}

let normalizeString = function (value) {
    if (typeof value === "string") {
        return value.replace(/\s+/g, ' ').trim()
        //https://futurestud.io/tutorials/remove-extra-spaces-from-a-string-in-javascript-or-node-js
    }
    return value;
}

let fetchIframeData = function () {
    getScrapedDataRoute.value = '';
    iframeReadyStatus.value = false;
    let callback = function (res) {
        //html
        crawlData.value = res.data
        //Next step
        getScrapedDataRoute.value = "/admin/products/scrapes/api/get-scraped-data"
    }
    scrapeHtml(url.value, callback)
}

const scrapeHtml = async function (url, callback = null) {
    let htmlValue = null;
    callback = callback !== null
        ? callback
        : function (res) {
            htmlValue = res.data
        }
    await axios.post("/admin/products/scrapes/api/scrape-html", {
        'url': url
    }).then(callback)
        .catch((res) => {
            Swal.fire(labels.status.canceled, res.message, "error");
        })
    return htmlValue;
}
let fetchData = async function () {
    return await axios
        .post("/admin/products/scrapes/api/fetch-model-data", {
            id: props.id
        })
        .then(response => {
            let data = response.data
            categories.data = data["categories"];
            sellers.data = data["sellers"];
            let model = data['model'];
            selectedSeller.value = model['seller_id'];
            selectedCategory.value = model['product_category_id'];
            url.value = model['url'];
            products.data = data['products'];

            let modelData = JSON.parse(model['data']);

            let localSample = modelData.hasOwnProperty('sample')
                ? modelData['sample']
                : null;
            if (localSample) {
                for (const key in localSample) {
                    sample[key] = localSample[key]
                }
            }

            let localQueryData = modelData.hasOwnProperty('queryData')
                ? modelData['queryData']
                : null;
            if (localQueryData) {
                for (const key in localQueryData) {
                    queryData[key] = localQueryData[key]
                }
            }

            let htmlTextContent = modelData.hasOwnProperty('htmlTextContent')
                ? modelData['htmlTextContent']
                : null;
            if (htmlTextContent) {
                iframeInnerText.value = htmlTextContent
            }

            pagination.array = JSON.parse(model['children'])
        })
        .catch(exception => {
        })
}
let initializeSelect2 = function () {
    $('select.select2').select2({
        theme: "classic",
    });
}

let addItem = function (obj = null) {
    let newItem = obj !== null
        ? obj
        : {
            id: randomGenerator(),
            title: "",
            image: "",
            url: "",
            price: "",
            original_price: "",
        }
    products.data.push(newItem);
}

function randomGenerator(except = []) { //id generator (optional)
    let value = null;
    do {
        value = Date.now() - Math.floor(Math.random() * 10);
    } while (except.find(item => item === value))
    return value;
}

const iframeReadyHandler = function () {
    iframeReadyStatus.value = true;
    try {
        //transfer new data
        iframeInnerHTML.value = iframe.value.contentDocument.body.innerHTML;
        iframeInnerText.value = iframe.value.contentDocument.body.innerText;
    } catch (e) {
        console.warn('iframeReadyHandler')
    }
}


onMounted(async () => {
    await fetchData()
    initializeSelect2()
})


function getPathTo(toElement, fromElement) {
    if (toElement.id !== '')
        return 'id("' + toElement.id + '")';
    if (toElement === fromElement)
        return toElement.tagName;
    let ix = 0;
    let siblings = toElement.parentNode.childNodes;
    for (let i = 0; i < siblings.length; i++) {
        let sibling = siblings[i];
        if (sibling === toElement)
            return getPathTo(toElement.parentNode, fromElement) + '/' + toElement.tagName + '[' + (ix + 1) + ']';
        if (sibling.nodeType === 1 && sibling.tagName === toElement.tagName)
            ix++;
    }
}

const paginationListRemove = function(item) {
    pagination.array = pagination.array.filter(arrItem => arrItem['id'] !== item['id'])
}

</script>

<style scoped>
iframe {
    min-height: 50vh;
    width: 100%;
}

</style>
