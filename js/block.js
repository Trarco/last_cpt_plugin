(function (blocks, editor, element, components) {
  var el = element.createElement;
  var registerBlockType = blocks.registerBlockType;
  var InspectorControls = editor.InspectorControls;
  var SelectControl = components.SelectControl;
  var ToggleControl = components.ToggleControl;

  registerBlockType("last-cpt/block", {
    title: "Last CPT",
    icon: "list-view",
    category: "widgets",
    attributes: {
      tipo: {
        type: "string",
        default: "post",
      },
      numero: {
        type: "number",
        default: 5,
      },
      show_thumbnail: {
        type: "boolean",
        default: true,
      },
      thumbnail_size: {
        type: "string",
        default: "thumbnail",
      },
      categoria: {
        type: "string",
        default: "",
      },
    },
    edit: function (props) {
      var attributes = props.attributes;
      var setAttributes = props.setAttributes;

      // Costruisci le opzioni per i tipi di post
      var postTypesOptions = Object.keys(lastCptData.postTypes).map(function (
        key
      ) {
        return {
          label: lastCptData.postTypes[key].labels.singular_name,
          value: lastCptData.postTypes[key].name,
        };
      });

      // Controlla se i dati delle categorie sono disponibili
      var categoriesOptions = lastCptData.categories
        ? lastCptData.categories.map(function (category) {
            return {
              label: category.name,
              value: category.slug,
            };
          })
        : [];

      return [
        el(
          InspectorControls,
          {},
          el(
            "div",
            { className: "components-panel__body" },
            el(SelectControl, {
              label: "Tipo di post:",
              value: attributes.tipo,
              options: postTypesOptions,
              onChange: function (newTipo) {
                setAttributes({ tipo: newTipo });
              },
            }),
            el(SelectControl, {
              label: "Categoria:",
              value: attributes.categoria,
              options: categoriesOptions,
              onChange: function (newCategoria) {
                setAttributes({ categoria: newCategoria });
              },
            }),
            el(
              "div",
              { className: "components-base-control" },
              el(
                "label",
                { className: "components-base-control__label" },
                "Numero di post:"
              ),
              el("input", {
                type: "number",
                value: attributes.numero,
                onChange: function (event) {
                  setAttributes({ numero: parseInt(event.target.value, 10) });
                },
              })
            ),
            el(ToggleControl, {
              label: "Mostra thumbnail",
              checked: attributes.show_thumbnail,
              onChange: function (newShowThumbnail) {
                setAttributes({ show_thumbnail: newShowThumbnail });
              },
            }),
            el(SelectControl, {
              label: "Dimensione thumbnail:",
              value: attributes.thumbnail_size,
              options: [
                { label: "Thumbnail", value: "thumbnail" },
                { label: "Full", value: "full" },
              ],
              onChange: function (newSize) {
                setAttributes({ thumbnail_size: newSize });
              },
            })
          )
        ),
        el(
          "div",
          { className: props.className },
          "Last CPT Block",
          el(SelectControl, {
            label: "Tipo di post:",
            value: attributes.tipo,
            options: postTypesOptions,
            onChange: function (newTipo) {
              setAttributes({ tipo: newTipo });
            },
          }),
          el(SelectControl, {
            label: "Categoria:",
            value: attributes.categoria,
            options: categoriesOptions,
            onChange: function (newCategoria) {
              setAttributes({ categoria: newCategoria });
            },
          }),
          el(
            "div",
            {},
            el("label", {}, "Numero di post:"),
            el("input", {
              type: "number",
              value: attributes.numero,
              onChange: function (event) {
                setAttributes({ numero: parseInt(event.target.value, 10) });
              },
            })
          ),
          el(ToggleControl, {
            label: "Mostra thumbnail",
            checked: attributes.show_thumbnail,
            onChange: function (newShowThumbnail) {
              setAttributes({ show_thumbnail: newShowThumbnail });
            },
          }),
          el(SelectControl, {
            label: "Dimensione thumbnail:",
            value: attributes.thumbnail_size,
            options: [
              { label: "Thumbnail", value: "thumbnail" },
              { label: "Full", value: "full" },
            ],
            onChange: function (newSize) {
              setAttributes({ thumbnail_size: newSize });
            },
          })
        ),
      ];
    },
    save: function () {
      return null; // Gli attributi verranno gestiti dal server
    },
  });
})(window.wp.blocks, window.wp.editor, window.wp.element, window.wp.components);
