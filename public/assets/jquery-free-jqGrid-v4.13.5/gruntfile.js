﻿/*global module,require*/
module.exports = function (grunt) {
	grunt.initConfig({
		pkgFreejqGrid: grunt.file.readJSON("package.json"),
		clean: [
			"css/*.min.css",
			"css/*.min.css.map",
			"js/jquery.jqgrid.min.js",
			"js/jquery.jqgrid.min.map",
			"js/jquery.jqgrid.src.js",
			"js/i18n/min/",
			"js/min/",
			"plugins/min/",
			"dist/",
			"plugins/*.min.js",
			"plugins/*.min.css",
			"plugins/*.min.css.map",
			"plugins/*.min.map",
			"js/i18n/grid.locale-*.min.js",
			"js/i18n/grid.locale-*.min.map"
		],
		copy: {
			main: {
				files: [
					{
						src: ["js/i18n/grid.locale-*.*"],
						dest: "dist/i18n/",
						//timestamp: true,
						expand: true,
						filter: "isFile",
						flatten: true
					},
					{
						src: ["plugins/*"],
						dest: "dist/plugins/",
						//timestamp: true,
						expand: true,
						filter: "isFile",
						flatten: true
					},
					{
						src: ["css/*"],
						dest: "dist/css/",
						//timestamp: true,
						expand: true,
						filter: "isFile",
						flatten: true
					},
					{
						src: ["js/jquery.jqgrid.src.js", "js/jquery.jqgrid.min.js", "js/jquery.jqgrid.min.map"],
						dest: "dist/",
						expand: true,
						flatten: true
					},
					{
						src: [
							"js/*.js",
							"!js/min/*.js",
							"!js/jquery.jqgrid.*.js"
						],
						dest: "dist/modules/",
						//timestamp: true,
						expand: true,
						filter: "isFile",
						flatten: true
					},
					{
						src: [
							"js/min/*.js",
							"js/min/*.map"
						],
						dest: "dist/modules/min",
						//timestamp: true,
						expand: true,
						filter: "isFile",
						flatten: true
					}
				]
			}
		},
		concat: {
			all: {
				options: {
					process: function (src, filepath) {
						// see https://github.com/gruntjs/grunt-contrib-concat#custom-process-function
						grunt.verbose.writeln("concat begin process the file " + filepath);
						// the below code is tested with Windows encoding of the files CRLF (\r\n for new line),
						// but it work with UNIX encoding LF (\n for new line) too.
						// One should modify the code to support other end-line characters (Macintosh CR,
						// Unicode line separator LS and Unicode pharagraph separator PS).
						var iBeginModule = src.indexOf("// begin module "), iLicenseEnd = 0, iBeginModuleStartLine,
							iEndModule, licenseComment = "", moduleCode = "", iRowStart, iRowEnd, margin = "";
						if (iBeginModule >= 0) {
							//grunt.log.writeln("first 3 characters are: '" + src.substring(0, 3) + "'");
							if (src.substring(0, 3) === "/**") {
								iLicenseEnd = src.substring(0, iBeginModule).indexOf("*/");
							}
							iBeginModuleStartLine = src.lastIndexOf("\n", iBeginModule);
							margin = src.substring(iBeginModuleStartLine + 1, iBeginModule);
							//grunt.log.writeln("margin: '" + margin + "'");
							iBeginModule = iBeginModuleStartLine + 1;
							if (iLicenseEnd > 0) {
								iLicenseEnd = src.indexOf("\n", iLicenseEnd);
								for (iRowStart = 0; iRowStart < iLicenseEnd; iRowStart = iRowEnd + 1) {
									iRowEnd = src.indexOf("\n", iRowStart);
									licenseComment += (iRowStart + 1 !== iRowEnd ? margin : "") + src.substring(iRowStart, iRowEnd + 1);
								}
								//grunt.log.writeln("License:\n" + licenseComment);
							}
							iEndModule = src.lastIndexOf("// end module ");
							if (iEndModule >= 0) {
								iEndModule = src.indexOf("\n", iEndModule);
								moduleCode = licenseComment + src.substring(iBeginModule, iEndModule + 1);
							}
						}
						if (filepath.lastIndexOf("grid.base.js") >= 0) {
							return src.substring(0, src.indexOf("}));", iEndModule));
						}
						return moduleCode;
					},
					footer: "}));\n"
				},
				src: [
					"js/grid.base.js",
					"js/grid.celledit.js",
					"js/grid.common.js",
					"js/grid.custom.js",
					"js/grid.filter.js",
					"js/jsonxml.js",
					"js/grid.formedit.js",
					"js/grid.grouping.js",
					"js/grid.import.js",
					"js/grid.inlinedit.js",
					"js/grid.jqueryui.js",
					"js/grid.pivot.js",
					"js/grid.subgrid.js",
					"js/grid.tbltogrid.js",
					"js/grid.treegrid.js",
					"js/jqdnr.js",
					"js/jqmodal.js",
					"js/jquery.fmatter.js"
				],
				dest: "js/jquery.jqgrid.src.js"
			}
		},
		jshint: {
			all: {
				src: ["js/jquery.jqgrid.src.js"],
				options: {
					//'-W069': false
					//"-W041": false,
					"boss": true,
					"curly": true,
					"eqeqeq": true,
					"eqnull": true,
					"expr": true,
					"immed": true,
					"noarg": true,
					//"quotmark": "double",
					"undef": true,
					"unused": true,
					"node": true
				}
			}
		},
		jscs: {
			all: {
				src: ["gruntfile.js", "js/*.js", "!js/*.min.js"],
				options: {
					config: ".jscsrc"
				}
			}
		},
		cssmin: {
			options: {
				sourceMap: true,
				report: "gzip"
			},
			target: {
				files: [
					{
						src: "css/ui.jqgrid.css",
						dest: "css/ui.jqgrid.min.css"
						// "sources":["css/ui.jqgrid.css"] in ui.jqgrid.min.css.map is wrong!!!
						// one have to fix it to "sources":["ui.jqgrid.css"]
					},
					{
						src: "plugins/ui.multiselect.css",
						dest: "plugins/ui.multiselect.min.css"
						// "sources":["plugins/ui.multiselect.css"] in ui.multiselect.min.css.map is wrong!!!
						// one have to fix it to "sources":["ui.multiselect.css"]
					}
				]
			}
		},
		closureCompiler: {
			options: {
				//checkModified: true,
				compilerOpts: {
					charset: "UTF-8",
					//create_source_map: null
					//warning_level: "QUIET",
					//warning_level: "verbose",
					//process_jquery_primitives: "", // This flag has no effect unless the compilation level is also set at ADVANCED_OPTIMIZATIONS.
					create_source_map: "js/jquery.jqgrid.min.map"
				},
				compilerFile: "node_modules/google-closure-compiler/compiler.jar"
			},
			targetName: {
				src: "js/jquery.jqgrid.src.js",
				dest: "js/jquery.jqgrid.min.js"
			}
		},
		watch: {
			files: [
				"js/*.js",
				"plugins/*.js",
				"css/*.css",
				"plugins/*.css",
				"!css/*.min.css",
				"!js/*.min.js",
				"!js/min/*.js",
				"!js/jquery.jqgrid.*.js",
				"!plugins/*.min.js",
				"!plugins/*.min.css",
				"!js/i18n/grid.locale-*.min.js",
				"!dist/**",
				'!node_modules/**'
				],
			tasks: ["default"]
		},
		replace: {
			cssmin_jqgrid: {
				src: "css/ui.jqgrid.min.css.map",
				dest: "./",
				options: {
					patterns: [{
						match: /\"sources\":\[\"css\/ui\.jqgrid\.css\"\],/,
						replacement: "\"sources\":[\"ui.jqgrid.css\"],"
					}]
				}
			},
			cssmin_multiselect: {
				src: "plugins/ui.multiselect.min.css.map",
				dest: "./",
				options: {
					patterns: [{
						match: /\"sources\":\[\"plugins\/ui\.multiselect\.css\"\],/,
						replacement: "\"sources\":[\"ui.multiselect.css\"],"
					}]
				}
			},
			dist: {
				options: {
					patterns: [
						{
							match: /\"sources\":\[\"js\/jquery\.jqgrid\.src\.js\"\],/,
							replacement: "\"sources\":[\"jquery.jqgrid.src.js\"],"
							/*replacement: function (match, offset, string, source, target) {
								grunt.log.writeln(" !!! replacement: match=" + match);
								grunt.log.writeln(" !!! replacement: offset=" + offset);
								grunt.log.writeln(" !!! replacement: string.lenth=" + string.length);
								grunt.log.writeln(" !!! replacement: source=" + source);
								grunt.log.writeln(" !!! replacement: target=" + target);
								return source;
							}*/
						},
						{
							match: /\"file\":\"js\/jquery\.jqgrid\.min\.js\",/,
							replacement: "\"file\":\"jquery.jqgrid.min.js\","
						}
					]
				},
				files: [
					{
						expand: true,
						flatten: true,
						src: ["js/jquery.jqgrid.min.map"],
						dest: "js/"
					}
				]
			}
		},
		file_append: {
			default_options: {
				files: [
					function () {
						return {
							append: "//# sourceMappingURL=jquery.jqgrid.min.map",
							input: "js/jquery.jqgrid.min.js"
						};
					}
				]
			}
		}//,
		//uglify: {
		//	all: {
		//		src: "js/jquery.jqgrid.src.js",
		//		dest: "js/jquery.jqgrid.min.js",
		//		options: {
		//			preserveComments: false,
		//			sourceMap: true,
		//			sourceMapName: "js/jquery.jqgrid.min.map",
		//			report: "min",
		//			banner: "/*\n" +
		//				" jqGrid <%= pkgFreejqGrid.version %> - free jqGrid: https://github.com/free-jqgrid/jqGrid\n" +
		//				" Copyright (c) 2008-2014, Tony Tomov, tony@trirand.com\n" +
		//				" Copyright (c) 2014-2016, Oleg Kiriljuk, oleg.kiriljuk@ok-soft-gmbh.com\n" +
		//				" Dual licensed under the MIT and GPL licenses\n" +
		//				" http://www.opensource.org/licenses/mit-license.php\n" +
		//				" http://www.gnu.org/licenses/gpl-2.0.html\n" +
		//				" Date: <%= grunt.template.today('isoDate') %>\n" +
		//				"*/",
		//			compress: {
		//				"hoist_funs": false
		//			}
		//		}
		//	}
		//}
	});

	grunt.loadNpmTasks("grunt-contrib-clean");
	grunt.loadNpmTasks("grunt-contrib-copy");
	grunt.loadNpmTasks("grunt-contrib-jshint");
	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-closure-tools");
	//grunt.loadNpmTasks("grunt-contrib-uglify");
	grunt.loadNpmTasks("grunt-contrib-cssmin");
	grunt.loadNpmTasks("grunt-replace");
	grunt.loadNpmTasks("grunt-file-append");
	grunt.loadNpmTasks("grunt-jscs");
	grunt.loadNpmTasks("grunt-contrib-watch");
	grunt.loadNpmTasks("grunt-newer");

	var closureCompilerTasks = [],
		regClosureCompilerTask = function (filePath, fileMinDir, fileMapDir) {
			// build names
			var filePathParts = filePath.split("\/"), filePathMin, filePathMap,
				fileName = filePathParts[filePathParts.length - 1], fileNameMin, fileNameMap,
				fileNameParts = fileName.split("."), regExp0, regExp1,
				escapeForMatch = function (path) {
					return path.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
				};

			if (fileNameParts[fileNameParts.length - 1].toLowerCase() !== "js" || fileNameParts.length < 2) { return; }
			if (fileNameParts[fileNameParts.length - 2].toLowerCase() !== "src") {
				if (fileMinDir === undefined) {
					fileNameParts[fileNameParts.length - 1] = "min";
					fileNameParts.push("js");
				}
			} else {
				fileNameParts[fileNameParts.length - 2] = "min";
			}
			fileNameMin = fileNameParts.join(".");
			fileNameParts[fileNameParts.length - 1] = "map";
			fileNameMap = fileNameParts.join(".");

			filePathParts[filePathParts.length - 1] = (fileMinDir || "") + fileNameMin;
			filePathMin = filePathParts.join("\/");

			filePathParts[filePathParts.length - 1] = (fileMapDir || "") + fileNameMap;
			filePathMap = filePathParts.join("\/");

			// build two regex required for running "replace" task
			// see http://stackoverflow.com/a/6969486/315935 about which characters need be escaped
			regExp0 = new RegExp("\\\"sources\\\":\\[\\\"" +
					//filePath.split("\/").join("\\\/") +    // for example "plugins\\\/grid.odata.js" +
					escapeForMatch(filePath) +
					"\\\"\\],");
			regExp1 = new RegExp("\\\"file\\\":\\\"" +
					//filePathMin.split("\/").join("\\\/") + // for example "plugins\\\/grid.odata.min.js" +
					escapeForMatch(filePathMin) +
					"\\\",");

			// build fileDirectory
			filePathParts.pop();
			var fileDirectory = filePathParts.join("\/");
			if (fileDirectory.length === 0) {
				fileDirectory = ".";
			}
			fileDirectory += "/";

			var taskSuffix = "_" + filePath.split("\/").join("_"),
				taskName = "closureCompiler" + taskSuffix;
			grunt.registerTask(taskName, function () {
				// run "closureCompiler" task
				grunt.config.set("closureCompiler.options.compilerOpts.create_source_map", filePathMap);
				//grunt.config.set("closureCompiler.options.compilerOpts.output_wrapper", '"%output%//# sourceMappingURL=' + fileNameMap + '"');
				grunt.config.set("closureCompiler.targetName.src", filePath);
				grunt.config.set("closureCompiler.targetName.dest", filePathMin);
				grunt.verbose.writeln("    compiling '" + filePath + "' to '" + filePathMin + "' with '" + filePathMap + "' by google closure compiler...");
				grunt.task.run("newer:closureCompiler:targetName");

				// run "replace" task
				//grunt.log.writeln(" ### regExp0=" + regExp0);
				//grunt.log.writeln(" ### replacement0=" + "\"sources\":[\"" +
				//	escapeForMatch((fileMinDir === undefined ? "" : "js\/") + fileName) +
				//	"\"],");
				//grunt.log.writeln(" ### regExp1='" + regExp1 + "'");
				//grunt.log.writeln(" ### replacement1=" + "\"file\":\"" +
				//	escapeForMatch((fileMinDir === undefined ? "" : "js\/" + fileMinDir) +	fileNameMin) +
				//	"\",");
				//grunt.log.writeln(" ### fileName='" + fileName + "'    ### fileNameMin='" +
				//				 fileNameMin + "'    ### fileNameMap='" + fileNameMap + "'");
				//grunt.log.writeln(" ### filePathMap='" + filePathMap + "'");
				//grunt.log.writeln(" ### fileDirectory='" + fileDirectory + (fileMinDir || "") + "'");

				// "sources":["js/jquery.jqgrid.src.js"],
				// "sources":["js/grid.base.js"],
				grunt.config.set("replace.dist.options.patterns.0.match", regExp0);
				grunt.config.set("replace.dist.options.patterns.0.replacement", "\"sources\":[\"" +
					(fileMinDir === undefined ? "" : "../") + fileName + "\"],");

				// "file":"js/jquery.jqgrid.min.js",
				// "file":"js/min/grid.base.js",
				grunt.config.set("replace.dist.options.patterns.1.match", regExp1);
				grunt.config.set("replace.dist.options.patterns.1.replacement", "\"file\":\"" + fileNameMin + "\",");
				grunt.config.set("replace.dist.files.0.src", [filePathMap]);

				grunt.config.set("replace.dist.files.0.dest", fileDirectory + (fileMinDir || ""));
				grunt.verbose.writeln("    patching 'sources' and 'file' properties of '" + filePathMap + "'");

				// run "file_append" task
				// consider to use grunt.file.write directly to prevent appending f
				grunt.config.set("file_append.default_options.files", [
					function () {
						var strToAppend = "//# sourceMappingURL=" + fileNameMap + "\n";
						//grunt.log.writeln(" ### !!!  filePathMin=" + filePathMin);
						var input = grunt.file.read(filePathMin);
						//grunt.log.writeln(" ### !!!  typeof input=" + (typeof input));
						//grunt.log.writeln(" ### !!!  input.length=" + input.length);
						if (input.lastIndexOf(strToAppend) < 0) {
							return {
								append: strToAppend,
								input: filePathMin
							};
						} else {
							//grunt.log.writeln(" ### !!!  skip append because the text already exist");
							return {
								append: "",
								input: filePathMin
							};
						}
					}
				]);
				grunt.verbose.writeln("    appending '//# sourceMappingURL=" + fileNameMap + "' at the end of 'file' properties of '" + filePathMin + "'");

				// TODO: register new task for file_append, which use grunt.task.requires("replace")
				grunt.registerTask("replace" + taskSuffix + ":dist", function () {
					grunt.task.requires("closureCompiler" + taskSuffix);
					grunt.task.run("replace:dist");
				});
				grunt.registerTask("file_append" + taskSuffix, function () {
					grunt.task.requires("replace" + taskSuffix + ":dist");
					grunt.task.run("file_append");
				});
				grunt.task.run(["replace" + taskSuffix + ":dist", "file_append" + taskSuffix]);
			});
			closureCompilerTasks.push(taskName);
		};

	regClosureCompilerTask("js/jquery.jqgrid.src.js");

	grunt.file.expand({ matchBase: true }, [
		"plugins/*.js",
		"!plugins/*.min.js",
		"js/i18n/grid.locale-*.js",
		"!js/i18n/grid.locale-*.min.js"
	]).forEach(function (path) {
		regClosureCompilerTask(path);
	});

	grunt.file.expand({ matchBase: true }, [
		"js/*.js",
		"!js/*.min.js",
		"!js/min/*.js",
		"!js/jquery.jqgrid.*.js"
	]).forEach(function (path) {
		regClosureCompilerTask(path, "min\/", "min\/");
	});

	grunt.registerTask("closureCompilerAll", closureCompilerTasks);

	grunt.registerTask("default", ["newer:concat:all", "newer:jshint:all", "newer:jscs:all", "closureCompilerAll",
		"newer:cssmin:target", "newer:replace:cssmin_jqgrid", "newer:replace:cssmin_multiselect",
		"copy"]);
	grunt.registerTask("all", ["clean", "default"]);
};
