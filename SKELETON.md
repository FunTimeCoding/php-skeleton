# Skeleton

This document explains project skeleton conventions.


## Directories

Unified directories for all projects. Create them only if necessary.

* bin - Script entry points.
* lib - The actual project code.
* test - Unit tests for the project code.
* doc - Documentation files.
* build - Files, executables and reports generated during build.


## Files

Unified files and scripts for all projects. All mentioned scripts have the argument `--ci-mode` to also write reports to `build` rather than just print them.

* README.md - The readme explaining how to install required dependencies and brief usage examples.
* build.sh - Builds the project including metrics, checks and tests.
* run-tests.sh - Run tests, provide access to individual test suites.
* run-style-check.sh - Code style and lint checks.
* run-metrics.sh - Collect metrics.
