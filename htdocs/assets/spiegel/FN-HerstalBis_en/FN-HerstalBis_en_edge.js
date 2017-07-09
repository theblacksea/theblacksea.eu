/*jslint */
/*global AdobeEdge: false, window: false, document: false, console:false, alert: false */
(function (compId) {

    "use strict";
    var im='images/',
        aud='media/',
        vid='media/',
        js='js/',
        fonts = {
        },
        opts = {
            'gAudioPreloadPreference': 'auto',
            'gVideoPreloadPreference': 'auto'
        },
        resources = [
        ],
        scripts = [
        ],
        symbols = {
            "stage": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "width",
                centerStage: "horizontal",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            id: 'browningrevolver',
                            type: 'image',
                            rect: ['12px', '16px', '403px', '272px', 'auto', 'auto'],
                            fill: ["rgba(0,0,0,0)",im+"browningrevolver.png",'0px','0px']
                        },
                        {
                            id: 'credit',
                            type: 'text',
                            rect: ['704px', '3px', 'auto', 'auto', 'auto', 'auto'],
                            text: "<p style=\"margin: 0px;\">​<span style=\"font-weight: 400;\">INFOGRAPHIE EIC</span></p>",
                            align: "left",
                            font: ['Arial, Helvetica, sans-serif', [10, "px"], "rgba(0,0,0,1)", "700", "none", "normal", "break-word", "nowrap"],
                            textStyle: ["", "", "", "", "none"]
                        },
                        {
                            id: 'titreGeneral',
                            type: 'text',
                            rect: ['13px', '377px', 'auto', 'auto', 'auto', 'auto'],
                            text: "<p style=\"margin: 0px;\">​Abaaoud’s Belgian FN Browning</p>",
                            font: ['Arial, Helvetica, sans-serif', [20, "px"], "rgba(0,0,0,1)", "700", "none", "", "break-word", "nowrap"]
                        },
                        {
                            id: 'browningrevolveRecto',
                            type: 'image',
                            rect: ['392px', '160px', '403px', '279px', 'auto', 'auto'],
                            fill: ["rgba(0,0,0,0)",im+"browningrevolveRecto.png",'0px','0px']
                        },
                        {
                            id: 'PoinconIntitule3',
                            type: 'image',
                            rect: ['13px', '44px', '76px', '283px', 'auto', 'auto'],
                            fill: ["rgba(0,0,0,0)",im+"PoinconIntitule.svg",'0px','0px']
                        },
                        {
                            id: 'FNIntitule2',
                            type: 'image',
                            rect: ['614px', '39px', '115px', '160px', 'auto', 'auto'],
                            fill: ["rgba(0,0,0,0)",im+"FNIntitule.svg",'0px','0px']
                        },
                        {
                            id: 'browningIntitule2',
                            type: 'image',
                            rect: ['222px', '58px', '90px', '137px', 'auto', 'auto'],
                            fill: ["rgba(0,0,0,0)",im+"browningIntitule.svg",'0px','0px']
                        },
                        {
                            id: 'PlaquettesIntitule',
                            type: 'image',
                            rect: ['514px', '395px', '199px', '15px', 'auto', 'auto'],
                            fill: ["rgba(0,0,0,0)",im+"PlaquettesIntitule.svg",'0px','0px']
                        },
                        {
                            id: 'bouton4',
                            symbolName: 'bouton4',
                            type: 'rect',
                            rect: ['61px', '49px', '25', '25', 'auto', 'auto'],
                            cursor: 'pointer'
                        },
                        {
                            id: 'bouton3',
                            symbolName: 'bouton3',
                            type: 'rect',
                            rect: ['605px', '194px', '25', '25', 'auto', 'auto'],
                            cursor: 'pointer'
                        },
                        {
                            id: 'bouton2',
                            symbolName: 'bouton2',
                            type: 'rect',
                            rect: ['704px', '390px', '25', '25', 'auto', 'auto'],
                            cursor: 'pointer'
                        },
                        {
                            id: 'Bouboutonton',
                            symbolName: 'Bouboutonton',
                            type: 'rect',
                            rect: ['218px', '55px', '18', '18', 'auto', 'auto']
                        },
                        {
                            id: 'Poincon',
                            symbolName: 'Poincon',
                            type: 'rect',
                            rect: ['424px', '41px', '362', '199', 'auto', 'auto']
                        },
                        {
                            id: 'Browning',
                            symbolName: 'Browning',
                            type: 'rect',
                            rect: ['424px', '26px', '362', '215', 'auto', 'auto'],
                            filter: [0.02, -1, 1, 1, 0, 0, 0, 0, "rgba(0,0,0,0)", 0, 0, 0]
                        },
                        {
                            id: 'FNHerstal',
                            symbolName: 'FNHerstal',
                            type: 'rect',
                            rect: ['12px', '202', '362', '199', 'auto', 'auto']
                        },
                        {
                            id: 'plaquetteFleche',
                            symbolName: 'plaquetteFleche',
                            type: 'rect',
                            rect: ['12px', '202', '692', '316', 'auto', 'auto']
                        },
                        {
                            id: 'introGenerale',
                            type: 'text',
                            rect: ['13px', '402px', '387px', '42px', 'auto', 'auto'],
                            text: "<p style=\"margin: 0px;\">​<span style=\"font-weight: 700;\">It is a semiautomatic Browning 1935 HP Sport, in working order but poor condition. The weapon bears no serial number and it could be a composite, rebuilt from two different Brownings.</span></p>",
                            align: "left",
                            font: ['Arial, Helvetica, sans-serif', [10, "px"], "rgba(0,0,0,1)", "400", "none", "normal", "break-word", "normal"],
                            textStyle: ["", "", "13px", "", "none"]
                        }
                    ],
                    style: {
                        '${Stage}': {
                            isStage: true,
                            rect: ['null', 'null', '800px', '450px', 'auto', 'auto'],
                            overflow: 'hidden',
                            fill: ["rgba(255,255,255,1)"]
                        }
                    }
                },
                timeline: {
                    duration: 0,
                    autoPlay: true,
                    data: [

                    ]
                }
            },
            "bouton": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            id: 'boutonOff',
                            type: 'image',
                            rect: ['4px', '4px', '18px', '18px', 'auto', 'auto'],
                            fill: ['rgba(0,0,0,0)', 'images/boutonOff.svg', '0px', '0px']
                        },
                        {
                            rect: ['4px', '4px', '18px', '18px', 'auto', 'auto'],
                            transform: [[], ['45'], [0, 0, 0], [1, 1, 1]],
                            id: 'boutonOn',
                            opacity: '1',
                            type: 'image',
                            fill: ['rgba(0,0,0,0)', 'images/boutonOn.svg', '0px', '0px']
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            rect: [null, null, '25px', '25px']
                        }
                    }
                },
                timeline: {
                    duration: 805,
                    autoPlay: false,
                    data: [
                        [
                            "eid12",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOff}",
                            '-45deg',
                            '0deg'
                        ],
                        [
                            "eid38",
                            "rotateZ",
                            405,
                            400,
                            "linear",
                            "${boutonOff}",
                            '0deg',
                            '-45deg'
                        ],
                        [
                            "eid8",
                            "opacity",
                            0,
                            405,
                            "linear",
                            "${boutonOn}",
                            '1',
                            '0'
                        ],
                        [
                            "eid14",
                            "opacity",
                            405,
                            400,
                            "linear",
                            "${boutonOn}",
                            '0',
                            '1'
                        ],
                        [
                            "eid6",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOn}",
                            '0deg',
                            '45deg'
                        ],
                        [
                            "eid16",
                            "rotateZ",
                            405,
                            400,
                            "linear",
                            "${boutonOn}",
                            '45deg',
                            '0deg'
                        ]
                    ]
                }
            },
            "bouton3": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            rect: ['4px', '4px', '18px', '18px', 'auto', 'auto'],
                            id: 'boutonOff3',
                            type: 'image',
                            fill: ['rgba(0,0,0,0)', 'images/boutonOff3.svg', '0px', '0px']
                        },
                        {
                            rect: ['4px', '4px', '18px', '18px', 'auto', 'auto'],
                            id: 'boutonOn3',
                            type: 'image',
                            fill: ['rgba(0,0,0,0)', 'images/boutonOn3.svg', '0px', '0px']
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            rect: [null, null, '25px', '25px']
                        }
                    }
                },
                timeline: {
                    duration: 805,
                    autoPlay: false,
                    data: [
                        [
                            "eid23",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOff3}",
                            '-45deg',
                            '0deg'
                        ],
                        [
                            "eid19",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOn3}",
                            '0deg',
                            '45deg'
                        ],
                        [
                            "eid20",
                            "rotateZ",
                            405,
                            400,
                            "linear",
                            "${boutonOn3}",
                            '45deg',
                            '0deg'
                        ],
                        [
                            "eid21",
                            "opacity",
                            0,
                            405,
                            "linear",
                            "${boutonOn3}",
                            '1',
                            '0'
                        ],
                        [
                            "eid22",
                            "opacity",
                            405,
                            400,
                            "linear",
                            "${boutonOn3}",
                            '0',
                            '1'
                        ]
                    ]
                }
            },
            "bouton2": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            rect: ['4px', '4px', '18px', '18px', 'auto', 'auto'],
                            id: 'boutonOff2',
                            type: 'image',
                            fill: ['rgba(0,0,0,0)', 'images/boutonOff2.svg', '0px', '0px']
                        },
                        {
                            type: 'image',
                            id: 'boutonOn2',
                            opacity: '1',
                            rect: ['4px', '4px', '18px', '18px', 'auto', 'auto'],
                            fill: ['rgba(0,0,0,0)', 'images/boutonOn2.svg', '0px', '0px']
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            rect: [null, null, '25px', '25px']
                        }
                    }
                },
                timeline: {
                    duration: 810,
                    autoPlay: false,
                    data: [
                        [
                            "eid26",
                            "opacity",
                            0,
                            405,
                            "linear",
                            "${boutonOn2}",
                            '1',
                            '0'
                        ],
                        [
                            "eid60",
                            "opacity",
                            405,
                            405,
                            "linear",
                            "${boutonOn2}",
                            '0',
                            '1'
                        ],
                        [
                            "eid28",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOff2}",
                            '-45deg',
                            '0deg'
                        ],
                        [
                            "eid62",
                            "rotateZ",
                            405,
                            405,
                            "linear",
                            "${boutonOff2}",
                            '0deg',
                            '-45deg'
                        ],
                        [
                            "eid24",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOn2}",
                            '0deg',
                            '45deg'
                        ],
                        [
                            "eid61",
                            "rotateZ",
                            405,
                            405,
                            "linear",
                            "${boutonOn2}",
                            '45deg',
                            '0deg'
                        ]
                    ]
                }
            },
            "bouton4": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            rect: ['4px', '4px', '18px', '18px', 'auto', 'auto'],
                            id: 'boutonOff4',
                            type: 'image',
                            fill: ['rgba(0,0,0,0)', 'images/boutonOff4.svg', '0px', '0px']
                        },
                        {
                            rect: ['4px', '4px', '18px', '18px', 'auto', 'auto'],
                            id: 'boutonOn4',
                            type: 'image',
                            fill: ['rgba(0,0,0,0)', 'images/boutonOn4.svg', '0px', '0px']
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            rect: [null, null, '25px', '25px']
                        }
                    }
                },
                timeline: {
                    duration: 810,
                    autoPlay: false,
                    data: [
                        [
                            "eid31",
                            "opacity",
                            0,
                            405,
                            "linear",
                            "${boutonOn4}",
                            '1',
                            '0'
                        ],
                        [
                            "eid32",
                            "opacity",
                            405,
                            400,
                            "linear",
                            "${boutonOn4}",
                            '0',
                            '1'
                        ],
                        [
                            "eid29",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOn4}",
                            '0deg',
                            '45deg'
                        ],
                        [
                            "eid30",
                            "rotateZ",
                            405,
                            400,
                            "linear",
                            "${boutonOn4}",
                            '45deg',
                            '0deg'
                        ],
                        [
                            "eid33",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOff4}",
                            '-45deg',
                            '0deg'
                        ],
                        [
                            "eid50",
                            "rotateZ",
                            405,
                            405,
                            "linear",
                            "${boutonOff4}",
                            '0deg',
                            '-45deg'
                        ]
                    ]
                }
            },
            "browning": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            type: 'rect',
                            id: 'browning_cadre',
                            stroke: [1, 'rgba(48,108,195,1.00)', 'solid'],
                            rect: ['0px', '0px', '360px', '213px', 'auto', 'auto'],
                            fill: ['rgba(255,255,255,1.00)']
                        },
                        {
                            rect: ['10px', '2px', '209px', '29px', 'auto', 'auto'],
                            font: ['Arial, Helvetica, sans-serif', [20, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', ''],
                            align: 'left',
                            id: 'titre-browning',
                            textStyle: ['', '', '', '', 'none'],
                            text: '<p style=\"margin: 0px;\">​<span style=\"font-size: 14px;\">\" Browning made in Belgium \"</span></p><p style=\"margin: 0px;\"><span style=\"font-size: 14px;\">​</span></p>',
                            type: 'text'
                        },
                        {
                            rect: ['10px', '32px', '344px', '167px', 'auto', 'auto'],
                            font: ['Arial, Helvetica, sans-serif', [20, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', 'normal'],
                            align: 'left',
                            id: 'texte-browning',
                            textStyle: ['', '', '10px', '', 'none'],
                            text: '<p style=\"margin: 0px; line-height: 12px;\">​<span style=\"font-size: 12px; font-weight: 400;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\" \"Sed ut perspiciatis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta</span></p>',
                            type: 'text'
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            rect: [null, null, '362px', '215px']
                        }
                    }
                },
                timeline: {
                    duration: 1610,
                    autoPlay: false,
                    data: [
                        [
                            "eid34",
                            "border-color",
                            1610,
                            0,
                            "linear",
                            "${browning_cadre}",
                            'rgba(48,108,195,1.00)',
                            'rgba(48,108,195,1.00)'
                        ]
                    ]
                }
            },
            "Browning": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            rect: ['0px', '15px', '360px', '170px', 'auto', 'auto'],
                            id: 'Browning_cadre',
                            stroke: [1, 'rgba(48,108,195,1.00)', 'solid'],
                            type: 'rect',
                            fill: ['rgba(255,255,255,1.00)']
                        },
                        {
                            id: 'BrowningZoom',
                            type: 'image',
                            rect: ['238px', '15px', '108px', '48px', 'auto', 'auto'],
                            fill: ['rgba(0,0,0,0)', 'images/BrowningZoom.png', '0px', '0px']
                        },
                        {
                            rect: ['10px', '69px', '336px', '107px', 'auto', 'auto'],
                            textStyle: ['', '', '', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [20, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', 'normal'],
                            id: 'Browning-Texte',
                            text: '<p style=\"margin: 0px; line-height: 11px;\">​<span style=\"font-size: 10px; font-weight: 400;\">This mark clearly shows that the gun was manufactured in Belgium, but that does not necessarily make it a gun intended for the Belgian domestic market. It is a gun intended for export. It is a sporting gun, as shown by the adjustable backsight fitted to the bolt. However, since its breech bears the stamp of Liège Proof House, it has been approved for use in Belgium.</span></p><p style=\"margin: 0px; line-height: 11px;\"><span style=\"font-size: 10px; font-weight: 400;\"></span></p>',
                            align: 'left',
                            type: 'text'
                        },
                        {
                            rect: ['10px', '26px', 'auto', 'auto', 'auto', 'auto'],
                            textStyle: ['', '', '', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [20, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', 'nowrap'],
                            id: 'Browning-Titre',
                            text: '<p style=\"margin: 0px; line-height: 16px;\">​<span style=\"font-size: 16px;\">\" Browning S.A. </span></p><p style=\"margin: 0px; line-height: 16px;\"><span style=\"font-size: 16px;\">made in Belgium \"</span></p>',
                            align: 'left',
                            type: 'text'
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            isStage: 'true',
                            rect: [undefined, undefined, '362px', '215px']
                        }
                    }
                },
                timeline: {
                    duration: 0,
                    autoPlay: false,
                    data: [

                    ]
                }
            },
            "Poincon": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            rect: ['0px', '0px', '360px', '107px', 'auto', 'auto'],
                            id: 'PoinconCadre',
                            stroke: [1, 'rgba(48,108,195,1.00)', 'solid'],
                            type: 'rect',
                            fill: ['rgba(255,255,255,1.00)']
                        },
                        {
                            rect: ['11px', '4px', 'auto', 'auto', 'auto', 'auto'],
                            textStyle: ['', '', '', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [20, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', 'nowrap'],
                            id: 'PoinconTitre',
                            text: '<p style=\"margin: 0px;\">​Liège stamp<span style=\"font-size: 16px;\"></span></p>',
                            align: 'left',
                            type: 'text'
                        },
                        {
                            rect: ['11px', '32px', '336px', '66px', 'auto', 'auto'],
                            textStyle: ['', '', '', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [20, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', 'normal'],
                            id: 'PoinconTexte',
                            text: '<p style=\"margin: 0px; line-height: 11px;\">​<span style=\"font-size: 10px; font-weight: 400;\">The stamp of Liège Proof House was found on the breechblock, the part that the cartridge is slid into before being struck by the hammer. This means the weapon was cleared for use in Belgium and came from the Belgium market.</span></p><p style=\"margin: 0px; line-height: 11px;\"><span style=\"font-size: 10px; font-weight: 400;\"></span></p><p style=\"margin: 0px; font-family: Arial, Helvetica, sans-serif; font-weight: 400; font-style: normal; text-decoration: none; font-size: 12px; color: rgb(0, 0, 0); background-color: rgba(0, 0, 0, 0); letter-spacing: 0px; text-transform: none; word-spacing: 0px; text-align: left; text-indent: 0px; line-height: 12px;\"><br></p>',
                            align: 'left',
                            type: 'text'
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            isStage: 'true',
                            rect: [undefined, undefined, '362px', '199px']
                        }
                    }
                },
                timeline: {
                    duration: 0,
                    autoPlay: false,
                    data: [

                    ]
                }
            },
            "FNHerstal": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            rect: ['0px', '0px', '360px', '153px', 'auto', 'auto'],
                            id: 'FNCadre',
                            stroke: [1, 'rgba(48,108,195,1.00)', 'solid'],
                            type: 'rect',
                            fill: ['rgba(255,255,255,1.00)']
                        },
                        {
                            rect: ['12px', '12px', 'auto', 'auto', 'auto', 'auto'],
                            textStyle: ['', '', '', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [20, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', 'nowrap'],
                            id: 'FNTitre',
                            text: '<p style=\"margin: 0px; line-height: 16px;\">​<span style=\"font-size: 16px;\">\" Fabrique Nationale </span></p><p style=\"margin: 0px; line-height: 16px;\"><span style=\"font-size: 16px;\">Herstal \"</span></p>',
                            align: 'left',
                            type: 'text'
                        },
                        {
                            rect: ['12px', '56px', '340px', '78px', 'auto', 'auto'],
                            textStyle: ['', '', '', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [20, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', 'normal'],
                            id: 'FNTexte',
                            text: '<p style=\"margin: 0px; line-height: 11px;\">​<span style=\"font-size: 10px; font-weight: 400;\">The inscription on the left-hand site is not “Fabrique nationale d’armes de guerre”, so the bolt (the top part) was definitely intended for export. But the main body (the bottom half of the weapon, with the handle, </span></p><p style=\"margin: 0px; line-height: 11px;\"><span style=\"font-size: 10px; font-weight: 400;\">the trigger and the striker) seem to be made of a light alloy, so their origin could be different.</span></p>',
                            align: 'left',
                            type: 'text'
                        },
                        {
                            id: 'herstalZoom',
                            type: 'image',
                            rect: ['188px', '0px', '164px', '29px', 'auto', 'auto'],
                            fill: ['rgba(0,0,0,0)', 'images/herstalZoom.png', '0px', '0px']
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            isStage: 'true',
                            rect: [undefined, undefined, '362px', '199px']
                        }
                    }
                },
                timeline: {
                    duration: 0,
                    autoPlay: false,
                    data: [

                    ]
                }
            },
            "plaquettes": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            rect: ['0px', '-9px', '360px', '207px', 'auto', 'auto'],
                            id: 'PlaquettesCadre',
                            stroke: [1, 'rgba(48,108,195,1.00)', 'solid'],
                            type: 'rect',
                            fill: ['rgba(255,255,255,1.00)']
                        },
                        {
                            rect: ['13px', '1px', 'auto', 'auto', 'auto', 'auto'],
                            textStyle: ['', '', '', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [16, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', 'nowrap'],
                            id: 'PlaquettesTitre',
                            text: '<p style=\"margin: 0px;\">​Grip plates</p>',
                            align: 'left',
                            type: 'text'
                        },
                        {
                            rect: ['13px', '24px', '217px', '168px', 'auto', 'auto'],
                            textStyle: ['', '', '9px', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [16, 'px'], 'rgba(0,0,0,1)', '700', 'none', 'normal', 'break-word', 'normal'],
                            id: 'PlaquettesTextes',
                            text: '<p style=\"margin: 0px; line-height: 12px;\">​<span style=\"font-size: 10px; font-weight: 400;\">The grip has decorative plates to make it easier to hold. It was on the underside of the left-hand plate, inside the weapon, that Abaaoud’s only usable fingerprint was found. This shows that Abaaoud dismantled it. To clean it? Perhaps. To replace a broken grip plate? Perhaps. To cross a border? Unlikely. People who really know what they are doing might also remove these plates to adjust the force of the striker. But did Abaaoud know that?</span></p><p style=\"margin: 0px; line-height: 12px;\"><span style=\"font-size: 10px; font-weight: 400;\"></span></p>',
                            align: 'left',
                            type: 'text'
                        },
                        {
                            rect: ['208px', '-25px', '164px', '242px', 'auto', 'auto'],
                            transform: [[], [], [], ['0.73628', '0.69421']],
                            id: 'empreinteplaque2',
                            type: 'image',
                            clip: 'rect(0px 164px 238.7806854248047px 0px)',
                            fill: ['rgba(0,0,0,0)', 'images/empreinteplaque2.png', '0px', '0px']
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            isStage: 'true',
                            rect: [undefined, undefined, '540px', '316px']
                        }
                    }
                },
                timeline: {
                    duration: 0,
                    autoPlay: false,
                    data: [

                    ]
                }
            },
            "crosse": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            type: 'group',
                            id: 'Group',
                            rect: ['0px', '0px', '116', '194', 'auto', 'auto'],
                            c: [
                            {
                                transform: [[], ['10'], [0, 0, 0], [1, 1, 1]],
                                id: 'browningrevolverplaqueRecto',
                                type: 'image',
                                rect: ['15px', '6px', '86px', '182px', 'auto', 'auto'],
                                fill: ['rgba(0,0,0,0)', 'images/browningrevolverplaqueRecto.png', '0px', '0px']
                            },
                            {
                                rect: ['37px', '52px', '45px', '66px', 'auto', 'auto'],
                                id: 'Rectangle3',
                                stroke: [2, 'rgb(48, 108, 195)', 'dotted'],
                                type: 'rect',
                                fill: ['rgba(255,255,255,0.00)']
                            }]
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            rect: [null, null, '116px', '194px']
                        }
                    }
                },
                timeline: {
                    duration: 0,
                    autoPlay: false,
                    data: [

                    ]
                }
            },
            "fleche": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            transform: [[], ['20'], [0, 0, 0], [1, 1, 1]],
                            filter: [0, -3, 0.99, 1, 0, 0, 0, 0, 'rgba(0,0,0,0)', 0, 0, 0],
                            fi: [0, -3, 0.99, 1, 0, 0, 0, 0, 'rgba(0,0,0,0)', 0, 0, 0],
                            id: 'Fleche',
                            type: 'image',
                            rect: ['16px', '28px', '184px', '124px', 'auto', 'auto'],
                            fill: ['rgba(0,0,0,0)', 'images/Fleche.svg', '0px', '0px']
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            rect: [null, null, '215px', '179px']
                        }
                    }
                },
                timeline: {
                    duration: 500,
                    autoPlay: false,
                    data: [
                        [
                            "eid35",
                            "clip",
                            0,
                            500,
                            "easeInQuad",
                            "${Fleche}",
                            [0,186,120,184.82528686523438],
                            [0,186,120,0],
                            {valueTemplate: 'rect(@@0@@px @@1@@px @@2@@px @@3@@px)'}
                        ]
                    ]
                }
            },
            "plaquetteFleche": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            id: 'crosse',
                            symbolName: 'crosse',
                            rect: ['412px', '52px', '116', '194', 'auto', 'auto'],
                            type: 'rect'
                        },
                        {
                            id: 'fleche',
                            symbolName: 'fleche',
                            rect: ['477px', '38px', '215', '179', 'auto', 'auto'],
                            type: 'rect'
                        },
                        {
                            id: 'plaquettes',
                            symbolName: 'plaquettes',
                            rect: ['0px', '0px', '540', '316', 'auto', 'auto'],
                            type: 'rect'
                        },
                        {
                            rect: ['0px', '-189px', '361px', '167px', 'auto', 'auto'],
                            id: 'Rectangle',
                            stroke: [1, 'rgba(48,108,195,1.00)', 'solid'],
                            type: 'rect',
                            fill: ['rgba(255,255,255,1.00)']
                        },
                        {
                            rect: ['200px', '-194px', '336px', '200px', 'auto', 'auto'],
                            transform: [[], [], [], ['0.77793', '0.77793']],
                            id: 'empreintesDoigtsCopy',
                            type: 'image',
                            clip: 'rect(0px 143.58155822753906px 171.3971710205078px 0.4713124930858612px)',
                            fill: ['rgba(0,0,0,0)', 'images/empreintesDoigts.png', '0px', '0px']
                        },
                        {
                            rect: ['13px', '-189px', 'auto', 'auto', 'auto', 'auto'],
                            id: 'Text',
                            text: '<p style=\"margin: 0px;\">​<span style=\"font-size: 16px; font-weight: 700;\">Prints</span></p>',
                            font: ['Arial, Helvetica, sans-serif', [24, ''], 'rgba(0,0,0,1)', 'normal', 'none', '', 'break-word', 'nowrap'],
                            type: 'text'
                        },
                        {
                            rect: ['13px', '-161px', '215px', '141px', 'auto', 'auto'],
                            textStyle: ['', '', '10px', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [24, 'px'], 'rgba(0,0,0,1)', '800', 'none', 'normal', 'break-word', 'normal'],
                            id: 'Text2',
                            text: '<p style=\"margin: 0px;\">​<span style=\"font-size: 10px; font-weight: 400;\">After the St Denis attack, the weapon was in such poor condition that it was impossible to use any prints remaining on the outside. Abaaoud’s skin itself was in such a bad state that only five fingers seemed unscathed. Nevertheless, Abaaoud’s right index finger has been formally identified on the inside of the gun.</span></p><p style=\"margin: 0px;\"><span style=\"font-size: 10px; font-weight: 400;\"></span></p>',
                            align: 'left',
                            type: 'text'
                        },
                        {
                            rect: ['18', '-172', 'auto', 'auto', 'auto', 'auto'],
                            textStyle: ['', '', '', '', 'none'],
                            font: ['Arial, Helvetica, sans-serif', [24, 'px'], 'rgba(0,0,0,1)', '800', 'none', 'normal', 'break-word', 'nowrap'],
                            id: 'Text4',
                            text: '<p style=\"margin: 0px;\">​</p>',
                            align: 'left',
                            type: 'text'
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            isStage: 'true',
                            rect: [undefined, undefined, '692px', '316px']
                        }
                    }
                },
                timeline: {
                    duration: 500,
                    autoPlay: false,
                    data: [
                            [ "eid36", "trigger", 0, function executeSymbolFunction(e, data) { this._executeSymbolAction(e, data); }, ['play', '${fleche}', [] ] ]
                    ]
                }
            },
            "Bouboutonton": {
                version: "6.0.0",
                minimumCompatibleVersion: "5.0.0",
                build: "6.0.0.400",
                scaleToFit: "none",
                centerStage: "none",
                resizeInstances: false,
                content: {
                    dom: [
                        {
                            rect: ['0px', '0px', '18px', '18px', 'auto', 'auto'],
                            id: 'boutonOff1',
                            type: 'image',
                            fill: ['rgba(0,0,0,0)', 'images/boutonOff.svg', '0px', '0px']
                        },
                        {
                            rect: ['0px', '0px', '18px', '18px', 'auto', 'auto'],
                            id: 'boutonOn1',
                            type: 'image',
                            fill: ['rgba(0,0,0,0)', 'images/boutonOn.svg', '0px', '0px']
                        }
                    ],
                    style: {
                        '${symbolSelector}': {
                            rect: [null, null, '18px', '18px']
                        }
                    }
                },
                timeline: {
                    duration: 810,
                    autoPlay: false,
                    data: [
                        [
                            "eid64",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOn1}",
                            '0deg',
                            '45deg'
                        ],
                        [
                            "eid65",
                            "rotateZ",
                            405,
                            405,
                            "linear",
                            "${boutonOn1}",
                            '45deg',
                            '0deg'
                        ],
                        [
                            "eid66",
                            "opacity",
                            0,
                            405,
                            "linear",
                            "${boutonOn1}",
                            '1',
                            '0'
                        ],
                        [
                            "eid67",
                            "opacity",
                            405,
                            405,
                            "linear",
                            "${boutonOn1}",
                            '0',
                            '1'
                        ],
                        [
                            "eid68",
                            "rotateZ",
                            0,
                            405,
                            "linear",
                            "${boutonOff1}",
                            '-45deg',
                            '0deg'
                        ],
                        [
                            "eid69",
                            "rotateZ",
                            405,
                            405,
                            "linear",
                            "${boutonOff1}",
                            '0deg',
                            '-45deg'
                        ]
                    ]
                }
            }
        };

    AdobeEdge.registerCompositionDefn(compId, symbols, fonts, scripts, resources, opts);

    if (!window.edge_authoring_mode) AdobeEdge.getComposition(compId).load("FN-HerstalBis_en_edgeActions.js");
})("EDGE-1962861");
