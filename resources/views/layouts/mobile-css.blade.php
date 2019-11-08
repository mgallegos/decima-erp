<style>
@if(Agent::isMobile())
  #apps-tabs > li {
    display: none;
  }
@endif

@if(Agent::isPhone())

.mobile-breadcrumb {
  display: none !important;
}

.app-grid .ui-jqgrid-titlebar > span {
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.app-grid .ui-jqdialog.ui-jqgrid-bootstrap .ui-jqdialog-titlebar, .app-grid .ui-jqgrid.ui-jqgrid-bootstrap .ui-jqgrid-caption {
  border-bottom: 1px solid #cccccc !important;
}

.app-grid .ui-jqgrid-hdiv {
  display: none;
}

.app-grid .ui-jqgrid .ui-jqgrid-bdiv tr.ui-row-ltr>td {
  border-right-width: 0 !important;
}

.app-grid tr.jqgrow > td {
  padding: .4em .4em !important;
}

.app-grid div.panel-footer .fa {
  font-size: 1.5em !important;
}

.mobile-grid {
  width:100%;
  table-layout: fixed;
}

.mobile-grid tr, .mobile-grid td {
  padding: .4em !important;
  vertical-align: middle;
}

.mobile-grid-first-row {
  font-weight: bold;
}

.mobile-grid .mobile-grid-first-row > td:first-child, .mobile-grid .mobile-grid-second-row > td:first-child {
  /* background-color: yellow; */
  width: 70%;
  text-align:left;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.mobile-grid .mobile-grid-first-row > td:last-child, .mobile-grid .mobile-grid-second-row > td:last-child {
  /* background-color: blue; */
  width: 30%;
  text-align:right;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/*Extra small devices and Small devices*/
@media (max-width: 767px) {
  .app-grid div.panel-footer > div.ui-pager-control > table.ui-pg-table > tbody > tr > td:first-child {
    display: none;
  }

  .app-grid div.panel-footer > div.ui-pager-control > table.ui-pg-table > tbody > tr > td:nth-child(2), .app-grid div.panel-footer > div.ui-pager-control > table.ui-pg-table > tbody > tr > td:last-child {
    width: 100% !important;
    text-align: center !important;
    float: left;
    margin-top: 5px;
    margin-bottom: 5px;
  }
}
@else
.app-grid tr.jqgrow > td {
  padding: .4em .3em !important;
}
@endif
</style>
