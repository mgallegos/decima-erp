<style>
/*Align*/
.ql-align-center
{
  text-align: center !important;
}

.ql-align-justify
{
  text-align: justify !important;
}

.ql-align-right
{
  text-align: right !important;
}

/*Indent (tab)*/
.ql-editor ol li.ql-indent-1
{
  counter-increment: list-1 !important;
}

.ql-editor ol li.ql-indent-1:before
{
  content: counter(list-1, lower-alpha) '. ' !important;
}

.ql-editor ol li.ql-indent-1
{
  counter-reset: list-2 list-3 list-4 list-5 list-6 list-7 list-8 list-9 !important;
}

.ql-editor ol li.ql-indent-2
{
  counter-increment: list-2 !important;
}

.ql-editor ol li.ql-indent-2:before
{
  content: counter(list-2, lower-roman) '. ' !important;
}

.ql-editor ol li.ql-indent-2
{
  counter-reset: list-3 list-4 list-5 list-6 list-7 list-8 list-9 !important;
}

.ql-editor ol li.ql-indent-3
{
  counter-increment: list-3 !important;
}

.ql-editor ol li.ql-indent-3:before
{
  content: counter(list-3, decimal) '. ' !important;
}

.ql-editor ol li.ql-indent-3
{
  counter-reset: list-4 list-5 list-6 list-7 list-8 list-9 !important;
}

.ql-editor ol li.ql-indent-4
{
  counter-increment: list-4 !important;
}

.ql-editor ol li.ql-indent-4:before
{
  content: counter(list-4, lower-alpha) '. ' !important;
}

.ql-editor ol li.ql-indent-4
{
  counter-reset: list-5 list-6 list-7 list-8 list-9 !important;
}

.ql-editor ol li.ql-indent-5
{
  counter-increment: list-5 !important;
}

.ql-editor ol li.ql-indent-5:before
{
  content: counter(list-5, lower-roman) '. ' !important;
}

.ql-editor ol li.ql-indent-5
{
  counter-reset: list-6 list-7 list-8 list-9 !important;
}

.ql-editor ol li.ql-indent-6
{
  counter-increment: list-6 !important;
}

.ql-editor ol li.ql-indent-6:before
{
  content: counter(list-6, decimal) '. ' !important;
}

.ql-editor ol li.ql-indent-6
{
  counter-reset: list-7 list-8 list-9 !important;
}

.ql-editor ol li.ql-indent-7
{
  counter-increment: list-7 !important;
}

.ql-editor ol li.ql-indent-7:before
{
  content: counter(list-7, lower-alpha) '. ' !important;
}

.ql-editor ol li.ql-indent-7
{
  counter-reset: list-8 list-9 !important;
}

.ql-editor ol li.ql-indent-8
{
  counter-increment: list-8 !important;
}

.ql-editor ol li.ql-indent-8:before
{
  content: counter(list-8, lower-roman) '. ' !important;
}
.ql-editor ol li.ql-indent-8 {
  counter-reset: list-9 !important;
}
.ql-editor ol li.ql-indent-9 {
  counter-increment: list-9 !important;
}
.ql-editor ol li.ql-indent-9:before {
  content: counter(list-9, decimal) '. ' !important;
}
.ql-editor .ql-indent-1:not(.ql-direction-rtl) {
  padding-left: 3em !important;
}
.ql-editor li.ql-indent-1:not(.ql-direction-rtl) {
  padding-left: 4.5em !important;
}
.ql-editor .ql-indent-1.ql-direction-rtl.ql-align-right {
  padding-right: 3em !important;
}
.ql-editor li.ql-indent-1.ql-direction-rtl.ql-align-right {
  padding-right: 4.5em !important;
}
.ql-editor .ql-indent-2:not(.ql-direction-rtl) {
  padding-left: 6em !important;
}
.ql-editor li.ql-indent-2:not(.ql-direction-rtl) {
  padding-left: 7.5em !important;
}
.ql-editor .ql-indent-2.ql-direction-rtl.ql-align-right {
  padding-right: 6em !important;
}
.ql-editor li.ql-indent-2.ql-direction-rtl.ql-align-right {
  padding-right: 7.5em !important;
}
.ql-editor .ql-indent-3:not(.ql-direction-rtl) {
  padding-left: 9em !important;
}
.ql-editor li.ql-indent-3:not(.ql-direction-rtl) {
  padding-left: 10.5em !important;
}
.ql-editor .ql-indent-3.ql-direction-rtl.ql-align-right {
  padding-right: 9em !important;
}
.ql-editor li.ql-indent-3.ql-direction-rtl.ql-align-right {
  padding-right: 10.5em !important;
}
.ql-editor .ql-indent-4:not(.ql-direction-rtl) {
  padding-left: 12em !important;
}
.ql-editor li.ql-indent-4:not(.ql-direction-rtl) {
  padding-left: 13.5em !important;
}
.ql-editor .ql-indent-4.ql-direction-rtl.ql-align-right {
  padding-right: 12em !important;
}
.ql-editor li.ql-indent-4.ql-direction-rtl.ql-align-right {
  padding-right: 13.5em !important;
}
.ql-editor .ql-indent-5:not(.ql-direction-rtl) {
  padding-left: 15em !important;
}
.ql-editor li.ql-indent-5:not(.ql-direction-rtl) {
  padding-left: 16.5em !important;
}
.ql-editor .ql-indent-5.ql-direction-rtl.ql-align-right {
  padding-right: 15em !important;
}
.ql-editor li.ql-indent-5.ql-direction-rtl.ql-align-right {
  padding-right: 16.5em !important;
}
.ql-editor .ql-indent-6:not(.ql-direction-rtl) {
  padding-left: 18em !important;
}
.ql-editor li.ql-indent-6:not(.ql-direction-rtl) {
  padding-left: 19.5em !important;
}
.ql-editor .ql-indent-6.ql-direction-rtl.ql-align-right {
  padding-right: 18em !important;
}
.ql-editor li.ql-indent-6.ql-direction-rtl.ql-align-right {
  padding-right: 19.5em !important;
}
.ql-editor .ql-indent-7:not(.ql-direction-rtl) {
  padding-left: 21em !important;
}
.ql-editor li.ql-indent-7:not(.ql-direction-rtl) {
  padding-left: 22.5em !important;
}
.ql-editor .ql-indent-7.ql-direction-rtl.ql-align-right {
  padding-right: 21em !important;
}
.ql-editor li.ql-indent-7.ql-direction-rtl.ql-align-right {
  padding-right: 22.5em !important;
}
.ql-editor .ql-indent-8:not(.ql-direction-rtl) {
  padding-left: 24em !important;
}
.ql-editor li.ql-indent-8:not(.ql-direction-rtl) {
  padding-left: 25.5em !important;
}
.ql-editor .ql-indent-8.ql-direction-rtl.ql-align-right {
  padding-right: 24em !important;
}
.ql-editor li.ql-indent-8.ql-direction-rtl.ql-align-right {
  padding-right: 25.5em !important;
}
.ql-editor .ql-indent-9:not(.ql-direction-rtl) {
  padding-left: 27em !important;
}
.ql-editor li.ql-indent-9:not(.ql-direction-rtl) {
  padding-left: 28.5em !important;
}
.ql-editor .ql-indent-9.ql-direction-rtl.ql-align-right {
  padding-right: 27em !important;
}
.ql-editor li.ql-indent-9.ql-direction-rtl.ql-align-right {
  padding-right: 28.5em !important;
}
</style>
