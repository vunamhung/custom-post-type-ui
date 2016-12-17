<?php
class CPTUI_Import_JSON extends WP_CLI_Command {

	public $args;

	public $assoc_args;

	public $type;

	public $data = array();

	/**
	 * Imports and parses JSON into CPTUI settings.
	 *
	 * ## Options
	 * [--type]
	 * : What type of import this is. Available options are `post_type` and `taxonomy`.
	 * [--data-path]
	 * : The path to the file holding JSON data to import.
	 */
	public function import( $args, $assoc_args ) {
		$this->args       = $args;
		$this->assoc_args = $assoc_args;


		if ( ! isset( $this->assoc_args['type'] ) ) {
			WP_CLI::error( __( 'Please provide whether you are importing post types or taxonomies', 'custom-post-type-ui' ) );
		}

		if ( ! isset( $this->assoc_args['data-path'] ) ) {
			WP_CLI::error( __( 'Please provide a path to the file holding your CPTUI JSON data.', 'custom-post-type-ui' ) );
		}

		$this->type = $assoc_args['type'];

		$json = file_get_contents( $this->assoc_args['data-path'] );

		if ( empty( $json ) ) {
			WP_CLI::error( __( 'No JSON data found', 'custom-post-type-ui' ) );
		}

		if ( 'post_type' === $this->type ) {
			$this->data['cptui_post_import'] = $json;
		}

		if ( 'taxonomy' === $this->type ) {
			$this->data['cptui_tax_import'] = $json;
		}

		$result = cptui_import_types_taxes_settings( $this->data );

		if ( false === $result || 'import_fail' === $result ) {
			WP_CLI::error( sprintf( __( 'An error on import occurred', 'custom-post-type-ui' ) ) );
		} else {
			WP_CLI::success( sprintf( __( 'Imported %s successfully', 'custom-post-type-ui' ), $this->type ) );
		}
	}
}
WP_CLI::add_command( 'cptui', 'CPTUI_Import_JSON' );
