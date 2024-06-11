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

      return [
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
          el(
            "div",
            {},
            el("label", {}, "Numero di post:"),
            el("input", {
              type: "number",
              value: attributes.numero,
              onChange: function (event) {
                setAttributes({ numero: parseInt(event.target.value) });
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
                  setAttributes({ numero: parseInt(event.target.value) });
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
      ];
    },
    save: function () {
      return null;
    },
  });
})(
  window.wp.blocks,
  window.wp.editor,
  window.wp.element,
  window.wp.components,
  window.wp.data
);
