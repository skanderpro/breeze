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
                                                Hello,<br /><br />We require a quotation
                                                for the following <br />Material Brief.<br /><br /><strong
                                                >IMPORTANT: Please reply directly to
                                                    this </strong
                                                ><br /><strong
                                                >email attaching your quotation in PDF
                                                    format</strong
                                                ><br /><strong>
                                                    and using the following Ref:</strong
                                                ><br /><br />
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
                                      ><strong>{{$po->poNumber}}</strong></span
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
                                            <a href="{{ url('/cabinet/manageRequestQuotes') }}" style="text-decoration: none;color: inherit;width:100%;height:40px;border-radius:20px;align-items:center;justify-content:center;border:1px solid #314695; color: #314695; text-decoration: none; display: flex; position :relative;font-size:16px;line-height:22px;font-weight:700;box-shadow:none;background:0 0;cursor:pointer">View</a>
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
