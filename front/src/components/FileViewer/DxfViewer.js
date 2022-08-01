import React, { Component } from "react";

class DxfReader extends Component {
  viewFile = () => {
    // See index.js in the sample for more details
    var parser = new window.DxfParser();
    var dxf = parser.parseSync(fileReader.result);
    cadCanvas = new ThreeDxf.Viewer(
      dxf,
      document.getElementById("cad-view"),
      400,
      400
    );
  };
  render() {
    // return (
    // );
  }
}

export default DxfReader;
