@extends('layouts.mail')

@section('content')

    <table
        align="center"
        border="0"
        cellpadding="0"
        cellspacing="0"
        class="row row-5"
        role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt"
        width="100%"
    >
        <tbody>
        <tr>
            <td>
                <table
                    align="center"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    class="row-content stack"
                    role="presentation"
                    style="
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        background-color: #ffffff;
                        border-radius: 0;
                        color: #000000;
                        width: 600px;
                        margin: 0 auto;
                      "
                    width="600"
                >
                    <tbody>
                    <tr>
                        <td
                            class="column column-1"
                            style="
                              mso-table-lspace: 0pt;
                              mso-table-rspace: 0pt;
                              font-weight: 400;
                              text-align: left;
                              padding-left: 57px;
                              padding-right: 57px;
                              vertical-align: top;
                              border-top: 0px;
                              border-right: 0px;
                              border-bottom: 0px;
                              border-left: 0px;
                            "
                            width="100%"
                        >
                            <table
                                border="0"
                                cellpadding="0"
                                cellspacing="0"
                                class="paragraph_block block-1"
                                role="presentation"
                                style="
                                mso-table-lspace: 0pt;
                                mso-table-rspace: 0pt;
                                word-break: break-word;
                              "
                                width="100%"
                            >
                                <tr>
                                    <td class="pad">
                                        <div
                                            style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-size: 18px;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 21.599999999999998px;
                                    "
                                        >
                                            <p style="margin: 0">
                                                Hello,<br /><br />
                                                A new Purchase Order has been created for you:
                                                <br /><br />
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table
        align="center"
        border="0"
        cellpadding="0"
        cellspacing="0"
        class="row row-6"
        role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt"
        width="100%"
    >
        <tbody>
        <tr>
            <td>
                <table
                    align="center"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    class="row-content stack"
                    role="presentation"
                    style="
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        background-color: #ffffff;
                        border-radius: 0;
                        color: #000000;
                        width: 600px;
                        margin: 0 auto;
                      "
                    width="600"
                >
                    <tbody>
                    <tr>
                        <td
                            class="column column-1"
                            style="
                              mso-table-lspace: 0pt;
                              mso-table-rspace: 0pt;
                              font-weight: 400;
                              text-align: left;
                              padding-left: 57px;
                              padding-right: 57px;
                              vertical-align: top;
                              border-top: 0px;
                              border-right: 0px;
                              border-bottom: 0px;
                              border-left: 0px;
                            "
                            width="100%"
                        >
                            <table
                                border="0"
                                cellpadding="0"
                                cellspacing="0"
                                class="paragraph_block block-1"
                                role="presentation"
                                style="
                                mso-table-lspace: 0pt;
                                mso-table-rspace: 0pt;
                                word-break: break-word;
                              "
                                width="100%"
                            >
                                <tr>
                                    <td class="pad">
                                        <div
                                            style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-size: 30px;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 36px;
                                    "
                                        >
                                            <p style="margin: 0">
                                      <span
                                          style="
                                          word-break: break-word;
                                          color: #5172b8;
                                        "
                                      ><strong>EM-{{$creatPO->id}}</strong></span
                                      >
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table
        align="center"
        border="0"
        cellpadding="0"
        cellspacing="0"
        class="row row-7"
        role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt"
        width="100%"
    >
        <tbody>
        <tr>
            <td>
                <table
                    align="center"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    class="row-content stack"
                    role="presentation"
                    style="
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        background-color: #ffffff;
                        border-radius: 0;
                        color: #000000;
                        width: 600px;
                        margin: 0 auto;
                      "
                    width="600"
                >
                    <tbody>
                    <tr>
                        <td
                            class="column column-1"
                            style="
                              mso-table-lspace: 0pt;
                              mso-table-rspace: 0pt;
                              font-weight: 400;
                              text-align: left;
                              vertical-align: top;
                              border-top: 0px;
                              border-right: 0px;
                              border-bottom: 0px;
                              border-left: 0px;
                            "
                            width="100%"
                        >
                            <div
                                class="spacer_block block-1"
                                style="
                                height: 40px;
                                line-height: 40px;
                                font-size: 1px;
                              "
                            >
                                 
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table
        align="center"
        border="0"
        cellpadding="0"
        cellspacing="0"
        class="row row-8"
        role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt"
        width="100%"
    >
        <tbody>
        <tr>
            <td>
                <table
                    align="center"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    class="row-content stack"
                    role="presentation"
                    style="
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        background-color: #ffffff;
                        border-radius: 0;
                        color: #000000;
                        width: 600px;
                        margin: 0 auto;
                      "
                    width="600"
                >


                    <tbody>
                    <tr>
                        <td
                            class="column column-1"
                            style="
                              mso-table-lspace: 0pt;
                              mso-table-rspace: 0pt;
                              font-weight: 400;
                              text-align: left;
                              padding-left: 57px;
                              padding-right: 57px;
                              vertical-align: top;
                              border-top: 0px;
                              border-right: 0px;
                              border-bottom: 0px;
                              border-left: 0px;
                            "
                            width="100%"
                        >
                            <table
                                class="paragraph_block block-1"
                                role="presentation"
                                style="
                                mso-table-lspace: 0pt;
                                mso-table-rspace: 0pt;
                                word-break: break-word;
                              "
                                width="100%"
                            >
                                <tr>
                                    <td><p><span style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 36px;
                                    ">Task/Project Number: </span></p></td>
                                    <td><p><span style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 36px;
                                    ">{{ $creatPO->poProject }}</span></p></td>
                                </tr>
                                <tr>
                                    <td><p><span style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 36px;
                                    ">Contract: </span></p></td>
                                    <td><p><span style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 36px;
                                    ">{{ $creatPO->contract?->companyName }}</span></p></td>
                                </tr>
                                <tr>
                                    <td><p><span style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 36px;
                                    ">Job Location: </span></p></td>
                                    <td><p><span style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 36px;
                                    ">{{ $creatPO->poProjectLocation }}</span></p></td>
                                </tr>
                                <tr>
                                    <td><p><span style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 36px;
                                    ">Supplier Cost: </span></p></td>
                                    <td><p><span style="
                                      color: #332e2b;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 36px;
                                    ">{{ $creatPO->poValue }}</span></p></td>
                                </tr>
                            </table>

                            <br>
                            <br>

                            <table
                                border="0"
                                cellpadding="0"
                                cellspacing="0"
                                class="paragraph_block block-1"
                                role="presentation"
                                style="
                                mso-table-lspace: 0pt;
                                mso-table-rspace: 0pt;
                                word-break: break-word;
                              "
                                width="100%"
                            >
                                <tr>
                                    <td class="pad">
                                        <div
                                            style="
                                      color: #0a1e42;
                                      direction: ltr;
                                      font-family: 'Helvetica Neue', Helvetica,
                                        Arial, sans-serif;
                                      font-size: 14px;
                                      font-weight: 400;
                                      letter-spacing: 0px;
                                      line-height: 120%;
                                      text-align: center;
                                      mso-line-height-alt: 16.8px;
                                    "
                                        >
                                            <div style="margin: 0">
                                                <strong>Material Brief:</strong
                                                ><br /><br />

                                                {!! $creatPO->poNotes !!}
                                                {!! $creatPO->poMaterials !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <table
        align="center"
        border="0"
        cellpadding="0"
        cellspacing="0"
        class="row row-9"
        role="presentation"
        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt"
        width="100%"
    >
        <tbody>
        <tr>
            <td>
                <table
                    align="center"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    class="row-content stack"
                    role="presentation"
                    style="
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        background-color: #ffffff;
                        border-radius: 0;
                        color: #000000;
                        width: 600px;
                        margin: 0 auto;
                      "
                    width="600"
                >
                    <tbody>
                    <tr>
                        <td
                            class="column column-1"
                            style="
                              mso-table-lspace: 0pt;
                              mso-table-rspace: 0pt;
                              font-weight: 400;
                              text-align: left;
                              vertical-align: top;
                              border-top: 0px;
                              border-right: 0px;
                              border-bottom: 0px;
                              border-left: 0px;
                            "
                            width="100%"
                        >
                            <div
                                class="spacer_block block-1"
                                style="
                                height: 40px;
                                line-height: 40px;
                                font-size: 1px;
                              "
                            >
                                 
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

@endsection
